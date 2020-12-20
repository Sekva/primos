import requests
import time
import json

tempo_tentativa = 3 # em seg

# Requisita um novo trabalho
def requisitar(url, problema_id):
    flag = False
    res = ''
    url = url + 'api/requisitar/' + str(problema_id)
    while(not flag):
        res = requests.get(url)
        # code: OK, verifica se é uma lista
        if(res.status_code != 200 or not isinstance(res.json(), list)):
            print(f"!Erro ao requisitar um novo trabalho.")
            print(f"Tentando novamente em {tempo_tentativa} seg.")
            time.sleep(tempo_tentativa)
        else:
            flag = True
    return res.json()[0]

# Atualiza o status de um determinado trabalho
def attStatus(url, trabalho_id, status):
    flag = False
    res = ''
    while(not flag):
        url = url + 'api/att_status'
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

 # Faz a submissão de uma nova resposta
def enviarResposta(url, trabalho_id, conteudo):
    flag = False
    res = ''
    url = url + 'api/enviar_resposta/'
    while(not flag):
        form = "{\"trabalho_id\":%i, \"conteudo\":%s}" % (trabalho_id, conteudo)
        print(form)
        # res = requests.post(url, data=json.loads(form))
        res = requests.post(url, data=json.loads(form))
        if(res.status_code != 201): # code: Created
            print(f"!Erro ao salvar a resposta!. status_code: {res.status_code}")
            print(f"Tentando novamente em {tempo_tentativa} seg.")
            print(f"url:{url}")
            time.sleep(tempo_tentativa)
        else:
            flag = True
    return res.json()

def getVersaoApi(url):
    url = url + 'api/versao'
    res = requests.get(url)
    return res.text



# PARA TESTE:

# url_global = "http://127.0.0.1:8000/"
# trabalho_id_global = 86919
# problema_id_global = 1
#
# print(attStatus(url_global, trabalho_id_global, 0))
# print(requisitar(url_global, problema_id_global))
# print(attStatus(url_global, trabalho_id_global, 1))
# print(enviarResposta(url_global, trabalho_id_global, "esse eh o conteudo"))
