import requests
import time
import json

from Pesquisa_prob1.cliente_prob1 import *
from Pesquisa_prob2.cliente_prob2 import *

tempo_tentativa = 3 # em seg

def requisitar(url, problema_id):
    flag = False
    res = ''
    while(not flag):
        url = str(url) + 'api/requisitar/' + str(problema_id)
        res = requests.get(url)
        if(res.status_code != 200): # code: OK
            print(f"!Erro ao requisitar um novo trabalho.")
            print(f"Tentando novamente em {tempo_tentativa} seg.")
            time.sleep(tempo_tentativa)
        else:
            flag = True
    return res.json()[0]


def attStatus(url, trabalho_id, status):
    flag = False
    res = ''
    while(not flag):
        url = str(url) + 'api/att_status'
        form = "{\"trabalho_id\":%i,\"status\":%i}" % (trabalho_id, status)
        res = requests.put(url, params=json.loads(form))
        if(res.status_code != 200): # code: ok
            print(f"!Erro ao atualizar status do trabalho.!")
            print(f"status_code: {res.status_code}")
            print(f"Tentando novamente em {tempo_tentativa} seg.")
            time.sleep(tempo_tentativa)
        else:
            flag = True
    return res.json()


def enviarResposta(url, trabalho_id, conteudo):
    flag = False
    res = ''
    while(not flag):
        url = str(url) + 'api/enviar_resposta/'
        form = "{\"trabalho_id\":%i, \"conteudo\":\"%s\"}" % (trabalho_id, conteudo)
        res = requests.post(url, data=json.loads(form))
        if(res.status_code != 201): # code: Created
            print(f"!Erro ao salvar a resposta!. status_code: {res.status_code}")
            print(f"Tentando novamente em {tempo_tentativa} seg.")
            print(f"url:{url}")
            time.sleep(tempo_tentativa)
        else:
            flag = True
    return res.json()

def trabalhar(url, problema_id):
    trabalho = requisitar(url, problema_id)
    attStatus(url, trabalho['id'], 1)
    #
    # processar
    #
    return enviarResposta(url, trabalho_id, conteudo)


# url_global = "http://127.0.0.1:8000/"
# trabalho_id_global = 86919
# problema_id_global = 1
#
# print(attStatus(url_global, trabalho_id_global, 0))
# print(requisitar(url_global, problema_id_global))
# print(attStatus(url_global, trabalho_id_global, 1))
# print(enviarResposta(url_global, trabalho_id_global, "esse eh o conteudo"))
