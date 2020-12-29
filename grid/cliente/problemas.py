import time
import json
import threading
from ctypes import *

from comunicacao_api import *

def trabalhar(url, problema_id, diretorio_dados, funcao_lib):
    trabalho = requisitar(url, problema_id)
    if("conteudo" not in trabalho):
        return False
    # Atualiza o status para Processando
    if(str(attStatus(url, trabalho['id'], 1)['status']) != '1'):
        return False

    # Realiza o trabalho (solucionar)
    if(problema_id == 1):
        resposta = processar_prob_1(json.loads(trabalho['conteudo']), diretorio_dados, funcao_lib)
    elif(problema_id == 2):
        resposta = processar_prob_2(json.loads(trabalho['conteudo']), diretorio_dados, funcao_lib)
    elif(problema_id == 3):
        resposta = processar_prob_3(json.loads(trabalho['conteudo']), diretorio_dados, funcao_lib)
    elif(problema_id == 4):
        resposta = processar_prob_4(json.loads(trabalho['conteudo']), diretorio_dados, funcao_lib)
    # elif():
    #     resposta = processar_prob_1(url, json.loads(trabalho['conteudo']), diretorio_dados, funcao_lib)
    else:
        print("Número de processo desconhecido!")
        exit()

    if(resposta != False):
        for r in resposta:
            enviarResposta(url, trabalho['id'], r)
            # Ao enviar uma resposta, o servidor atualiza o status do trabalho automaticamente
    else:
        # Atualiza o status para processado (via cliente)
        if(str(attStatus(url, trabalho['id'], 3)['status']) != '3'):
            return False

    return True


# Quadrado perfeito: (p+q)^2 + p*q é quadrado perfeito
def processar_prob_1(trabalho_conteudo, diretorio_dados, funcao_lib):
    diretorio_dados += 'Lista_A.list'

    p = trabalho_conteudo["p"]
    q = trabalho_conteudo["q"]
    max_p = int(p) + trabalho_conteudo["k"]
    max_q = int(q) + trabalho_conteudo["k"]

    args = str(p) + "/" + str(max_p) + "/" + str(q) + "/" + str(max_q)
    start_time = time.time()
    # em c_short(x), ele recebe o id do problema
    p = funcao_lib(c_short(1), c_char_p(args.encode("utf-8")), c_char_p(diretorio_dados.encode("utf-8")))
    # print("[{:10d}] Processou em {:f} segundos".format(threading.get_native_id(), (time.time() - start_time)))
    print("Processou em {:f} segundos".format(time.time() - start_time))
    resultado = str(p.decode("utf-8"))
    vetor_retorno = []

    # separa as linhas do resultado
    linhas = resultado.split('\n')

    count_i = 0
    # string de retorno com TODAS as resposta para aquele problema
    str_json_final = "{"
    # pra cada linha do resultado, extrai o dados
    for resposta_achada in linhas:
        if not resposta_achada:
            continue
        p_q_r = resposta_achada.split('/')
        valor_p = int(p_q_r[0])
        valor_q = int(p_q_r[1])
        valor_r = int(p_q_r[2])
        str_aux = str(count_i)+":\"p:"+str(valor_p)+", q:"+str(valor_q)+", resultado_calculo:"+str(valor_r)+"\","
        str_json_final += str_aux
        count_i += 1
    str_json_final += "}"

    if(str_json_final == "{}"):
        return False
    else :
        # Esse dumps transforma a string numa string no molde de json
        return [json.dumps(str_json_final)]


# Primos Gêmeos: |p - q| = k
def processar_prob_2(trabalho_conteudo, diretorio_dados, funcao_lib):
    diretorio_dados += 'Lista_A.list'

    valor_inicial_p = trabalho_conteudo["valor_inicial_p"]
    quantidade = trabalho_conteudo["quantidade"]
    k = trabalho_conteudo["k"]

    args = str(valor_inicial_p) + "/" + str(quantidade) + "/" + str(k)
    start_time = time.time()
    # em c_short(x), ele recebe o id do problema
    p = funcao_lib(c_short(2), c_char_p(args.encode("utf-8")), c_char_p(diretorio_dados.encode("utf-8")))
    # print("[{:10d}] Processou em {:f} segundos".format(threading.get_native_id(), (time.time() - start_time)))
    print("Processou em {:f} segundos".format(time.time() - start_time))
    resultado = str(p.decode("utf-8"))
    vetor_retorno = []

    # separa as linhas do resultado
    linhas = resultado.split('\n')

    count_i = 0
    # string de retorno com TODAS as resposta para aquele problema
    str_json_final = "{"
    # pra cada linha do resultado, extrai o dados
    for resposta_achada in linhas:
        if not resposta_achada:
            continue
        p_q_k = resposta_achada.split('/')
        valor_p = int(p_q_k[0])
        valor_q = int(p_q_k[1])
        valor_k = int(p_q_k[2])
        str_aux = str(count_i)+":\"p:"+str(valor_p)+", q:"+str(valor_q)+", k:"+str(valor_k)+"\","
        str_json_final += str_aux
        count_i += 1
    str_json_final += "}"

    if(str_json_final == "{}"):
        return False
    else :
        # Esse dumps transforma a string numa string no molde de json
        return [json.dumps(str_json_final)]


# Primos de Mersenne: q = log2(p + 1)
def processar_prob_3(trabalho_conteudo, diretorio_dados, funcao_lib):
    diretorio_dados += 'Lista_A.list'

    valor_inicial_p = trabalho_conteudo["valor_inicial_p"]
    quantidade = trabalho_conteudo["quantidade"]

    args = str(valor_inicial_p) + "/" + str(valor_inicial_p+quantidade)
    print(f"args: {args}")
    start_time = time.time()
    # em c_short(x), ele recebe o id do problema
    p = funcao_lib(c_short(3), c_char_p(args.encode("utf-8")), c_char_p(diretorio_dados.encode("utf-8")))
    # print("[{:10d}] Processou em {:f} segundos".format(threading.get_native_id(), (time.time() - start_time)))
    print("Processou em {:f} segundos".format(time.time() - start_time))
    resultado = str(p.decode("utf-8"))
    vetor_retorno = []

    # separa as linhas do resultado
    linhas = resultado.split('\n')

    count_i = 0
    # string de retorno com TODAS as resposta para aquele problema
    str_json_final = "{"
    # pra cada linha do resultado, extrai o dados
    for resposta_achada in linhas:
        if not resposta_achada:
            continue
        p_q = resposta_achada.split('/')
        valor_p = int(p_q[0])
        valor_q = int(p_q[1])
        str_aux = str(count_i)+":\"p:"+str(valor_p)+", q:"+str(valor_q)+"\","
        str_json_final += str_aux
        count_i += 1
    str_json_final += "}"

    if(str_json_final == "{}"):
        return False
    else :
        # Esse dumps transforma a string numa string no molde de json
        return [json.dumps(str_json_final)]


# Primos de Fermat: q = log2(log2(p - 1))
def processar_prob_4(trabalho_conteudo, diretorio_dados, funcao_lib):
    diretorio_dados += 'Lista_A.list'

    valor_inicial_p = trabalho_conteudo["valor_inicial_p"]
    quantidade = trabalho_conteudo["quantidade"]

    args = str(valor_inicial_p) + "/" + str(valor_inicial_p+quantidade)
    print(f"args: {args}")
    start_time = time.time()
    # em c_short(x), ele recebe o id do problema
    p = funcao_lib(c_short(4), c_char_p(args.encode("utf-8")), c_char_p(diretorio_dados.encode("utf-8")))
    # print("[{:10d}] Processou em {:f} segundos".format(threading.get_native_id(), (time.time() - start_time)))
    print("Processou em {:f} segundos".format(time.time() - start_time))
    resultado = str(p.decode("utf-8"))
    vetor_retorno = []

    # separa as linhas do resultado
    linhas = resultado.split('\n')

    count_i = 0
    # string de retorno com TODAS as resposta para aquele problema
    str_json_final = "{"
    # pra cada linha do resultado, extrai o dados
    for resposta_achada in linhas:
        if not resposta_achada:
            continue
        p_q = resposta_achada.split('/')
        valor_p = int(p_q[0])
        valor_q = int(p_q[1])
        str_aux = str(count_i)+":\"p:"+str(valor_p)+", q:"+str(valor_q)+"\","
        str_json_final += str_aux
        count_i += 1
    str_json_final += "}"

    if(str_json_final == "{}"):
        return False
    else :
        # Esse dumps transforma a string numa string no molde de json
        return [json.dumps(str_json_final)]


# PARA TESTAR

# libtqp = CDLL("./libtqp.so")
# funcao_lib = libtqp._Z4progtPcS_
# funcao_lib.restype = c_char_p
# print(trabalhar_prob_1("http://127.0.0.1:8000/", 1, "./dados/", funcao_lib))
