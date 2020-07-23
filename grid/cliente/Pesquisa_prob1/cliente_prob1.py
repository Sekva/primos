import requests
import time

numero_tentativas_limite = 10

# Requisita dados para processar e retorna um dicionario
def requisitar_prob1(url):
    url_requisitar = url + 'requisitar.php'

    count_tentativas = 1
    while(True):
        resultado = requests.post(url_requisitar)
        if(len(resultado.text) > 5 and resultado.text[4] == "o" and resultado.text[5] == "k"):
            # print()
            # print(resultado.text)
            res_j = resultado.json()
            resultado = {
                'id':res_j[1][0],
                'p':res_j[2][0],
                'q':res_j[3][0],
                'k':res_j[4][0]
            }

            # print(resultado)
            return resultado
        # Caso em que não foi possível realizar a coleta de um novo trabalho
        else:
            if(count_tentativas > numero_tentativas_limite):
                return False
            print("FALHA AO REQUISITAR! (" + str(count_tentativas) + ")")
            print("Tentando novamente em 3 segundos...")
            time.sleep(3)
            count_tentativas += 1



# Atualiza status do processo e envia resultados
def enviar_prob1(url, status, res_requisitar ,res_processar = False):
    url_enviar = url + 'enviar.php'
    conteudoEnvio = ''
    if(status == 1):
        conteudoEnvio = {'atualizarStatus': '', 'id':res_requisitar['id'], 'status':'1', 'resposta':'false'}

    elif(res_processar != False): # quando terminar de processar
        if(res_processar['resposta'] == true): # obteve resposta
            conteudoEnvio = {
                'atualizarStatus':'',
                'id':res_requisitar['id'],
                'status':'3',
                'resposta':'true',
                'p':res_processar['p'],
                'q':res_processar['q'],
                'resultado_calculo':res_processar['resultado_calculo']
            }
        else: # nao obteve resposta
            conteudoEnvio = {'atualizarStatus': '', 'id':res_requisitar['id'], 'status':'3', 'resposta':'false'}

    count_tentativas = 1
    resultadoAttProcesso = requests.post(url_enviar, data = conteudoEnvio)
    while (resultadoAttProcesso.text[-2:] != 'ok'):
        if(count_tentativas > numero_tentativas_limite):
            return False

        print("Erro ao tentar atualizar status. Tentando novamente em 3 segundos. (" + count_tentativa_att + ")")
        time.sleep(3)
        resultadoAttProcesso = requests.post(url_enviar, data = conteudoEnvio)
        count_tentativas += 1

    return True


# Responsável pelo processamento dos dados
def processar_prob1(url, res_requisitar):
    sucesso_att = enviar_prob1(url, 1, res_requisitar)
    if(sucesso_att == False):
        return False

    ######
    #resultado = chamada do processamento
    ######

    # O retorno deve ser um dicionário contendo:
    # [resposta, p, q, resultado_calculo]
    # o campo resposta é um boolean
        # (true para quando achar um resultado)
        # [resposta:true, p:3, q:7, resultado_calculo:121]
    return resultado


def trabalhar_prob1(url):

    # Requisita um novo trabalho
    res_requisitar = requisitar_prob1(url)
    if(res_requisitar == False):
        return False

    Processa o trabalho requisitado
    res_processar = processar_prob1(url, res_requisitar)
    if(res_processar == False):
        return False

    Submete o trabalho processado
    res_enviar = enviar_prob1(url, 3, res_requisitar, res_processar)
    return res_enviar

trabalhar_prob1('http://localhost:8000/Pesquisa_prob1/')
