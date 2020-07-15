
# status:
#   0 = livre
#   1 = Está processando
#   2 = Está ausente (nao usar por agora)
#   3 = Terminado


import requests
import time


url_global = "http://localhost:8000/"


# requisita
'''
url = url_global + 'Pesquisa_prob1/requisitar.php'
resultado = requests.post(url)
# Caso um trabalho seja entregue, é relizado o processamento
if(len(resultado.text) > 5 and resultado.text[4] == "o" and resultado.text[5] == "k"):
    print()
    print(resultado.text)
    rj = resultado.json()
    id = rj[1][0]
    p = rj[2][0]
    q = rj[3][0]
    k = rj[4][0]
    print("id:" + str(id), "p:" + str(p), "q:" + str(q), "k:" + str(k))
    print()
# Caso em que não foi possível realizar a coleta de um novo trabalho
else:
    print("FALHA AO REQUISITAR!")
'''


# att status
'''
url = url_global + 'Pesquisa_prob1/enviar.php'
conteudoEnvio = {'atualizarStatus': '', 'id': '46587', 'status':'1', 'resposta':'false'}
resultadoAttStatus = requests.post(url, data = conteudoEnvio)
'''


# Att status e envia resposta
'''
print("Abrindo escopo envio resposta")
url = url_global + 'Pesquisa_prob1/enviar.php'
# Status processando = 1
conteudoEnvio = {'atualizarStatus': '', 'id': 46587, 'status':'3', 'resposta':'true', 'p':'3', 'q':'7', 'resultado_calculo':'121'}
resultadoEnvioResposta = requests.post(url, data = conteudoEnvio)
print(resultadoEnvioResposta.text)
print("Fechando escopo envio resposta")
'''
