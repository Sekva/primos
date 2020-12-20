import requests
import time
import threading
from ctypes import *

numero_tentativas_limite = 10

# Requisita dados para processar e retorna um dicionario
def requisitar_prob2(url):
    url_requisitar = url + 'requisitar.php'

    count_tentativas = 1
    while(True):
        resultado = requests.post(url_requisitar)
        if(len(resultado.text) > 4 and resultado.text[4] == "o" and resultado.text[5] == "k"):
            # print()
            # print(resultado.text)
            res_j = resultado.json()
            resultado = {
                'id':res_j[1][0],
                'idx_min':res_j[2][0],
                'idx_max':res_j[3][0],
                'k':res_j[4][0]
            }

            # print(resultado)
            return resultado
        # Caso em que não foi possível realizar a coleta de um novo trabalho
        else:
            if(count_tentativas > numero_tentativas_limite):
                return False
            print("[{:10d}] FALHA AO REQUISITAR! (".format(threading.get_native_id()) + str(count_tentativas) + ")")
            print("[{:10d}] Tentando novamente em 3 segundos...".format(threading.get_native_id()))
            time.sleep(3)
            count_tentativas += 1


def tentar_enviar(url_enviar, conteudoEnvio):
    count_tentativas = 1
    resultadoAttProcesso = requests.post(url_enviar, data = conteudoEnvio)
    while (resultadoAttProcesso.text[-2:] != 'ok'):
        if(count_tentativas > numero_tentativas_limite):
            return False

        print("[{:10d}] Erro ao tentar atualizar status. Tentando novamente em 3 segundos. (".format(threading.get_native_id()) + str(count_tentativas) + ")")
        time.sleep(3)
        resultadoAttProcesso = requests.post(url_enviar, data = conteudoEnvio)
        count_tentativas += 1
    return True


# Atualiza status do processo e envia resultados
def enviar_prob2(url, status, res_requisitar, res_processar = False):
    url_enviar = url + 'enviar.php'
    conteudoEnvio = ''
    if(status == 1):
        conteudoEnvio = {'atualizarStatus': '', 'id':res_requisitar['id'], 'status':'1', 'resposta':'false'}
        return tentar_enviar(url_enviar, conteudoEnvio)

    # Caso de termino de processamento de trabalho (encontrando ou não resposta)
    elif(res_processar != False): # quando terminar de processar
        for resp_i in res_processar:
            if(resp_i['resposta'] == 'true'): # obteve resposta
                conteudoEnvio = {
                    'atualizarStatus':'',
                    'id':res_requisitar['id'],
                    'status': status,
                    'resposta':'true',
                    'p':resp_i['p'],
                    'p_i':resp_i['p_i'],
                    'q':resp_i['q'],
                    'q_i':resp_i['q_i'],
                    'k':resp_i['k']
                }
            else: # nao obteve resposta
                conteudoEnvio = {'atualizarStatus': '', 'id':res_requisitar['id'], 'status': status, 'resposta':'false'}

            # Pois está dentro de um for, se colocar direto o return, quando True, vai encerrar a funcao
            if(tentar_enviar(url_enviar, conteudoEnvio) == False):
                return False # encerra a funcao no primeiro erro

        return True # Ao sair do for e concluir todos os envios

    return False # Por via das duvidas (caso chame a funcao de modo errado)


# Responsável pelo processamento dos dados
def processar_prob2(url, res_requisitar, diretorio_dados, funcao_lib):
    diretorio_dados += 'Lista_A.list'

    sucesso_att = enviar_prob2(url, 1, res_requisitar)
    if(sucesso_att == False):
        return False

    idx_min = res_requisitar["idx_min"]
    idx_max = res_requisitar["idx_max"]
    grau_pk = res_requisitar["k"]

    args = str(idx_min) + "/" + str(idx_max) + "/" + str(grau_pk)
    start_time = time.time()
    p = funcao_lib(c_short(2), c_char_p(args.encode("utf-8")), c_char_p(diretorio_dados.encode("utf-8")))
    print("[{:10d}] Processou em {:f} segundos".format(threading.get_native_id(), (time.time() - start_time)))
    resultado = str(p.decode("utf-8"))

    dicionarios_retorno = []

    # verifica se tem resultado e se não, já retorna daqui
    if not resultado:
        print("[{:10d}] Sem resposta....".format(threading.get_native_id()))
        return [{"resposta": False, "p": 0, "q": 0, "k": 0, "p_i": 0, "q_i": 0}]

    # separa as linhas do resultado
    linhas = resultado.split('\n')


    # pra cada linha do resultado, extrai o dados
    for resposta_achada in linhas:
        if not resposta_achada:
            continue

        p_q_r = resposta_achada.split('/')
        valor_p = p_q_r[0]
        valor_q = p_q_r[1]
        valor_k = p_q_r[2]
        valor_pi = p_q_r[3]
        valor_qi = p_q_r[4]
        dicionario_da_resposta = {"resposta": 'true', "p": valor_p, "q": valor_q, "k": valor_k, "p_i": valor_pi, "q_i": valor_qi}
        dicionarios_retorno.append(dicionario_da_resposta)

    # vetor de dicionarios
    return dicionarios_retorno


def trabalhar_prob2(url, diretorio_dados, funcao_lib):

    # Requisita um novo trabalho
    res_requisitar = requisitar_prob2(url)
    if(res_requisitar == False):
        return False

    #Processa o trabalho requisitado
    res_processar = processar_prob2(url, res_requisitar, diretorio_dados, funcao_lib)
    if(res_processar == False):
        return False

    #Submete o trabalho processado

    print("[{:10d}] Enviando dados do problema...".format(threading.get_native_id()))
    res_enviar = enviar_prob2(url, 3, res_requisitar, res_processar)
    print("[{:10d}] Enviado.".format(threading.get_native_id()))
    return res_enviar
