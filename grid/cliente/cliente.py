#!/bin/python3


import requests
import sys
import os
import subprocess
import time
import threading
from ctypes import *

from trabalhar import trabalhar


versao = "1.2.0"
numeroDeThreads = 1
nomeCliente = "user"


url_global = "http://173.82.94.37/"

id_prob = 1

diretorio_dados = "./dados/"


libtqp = CDLL("./libtqp.so")
funcao_lib = libtqp._Z4progtPcS_
funcao_lib.restype = c_char_p


# [codigo&id, Nome_pequeno_do_prob]
nomes_prob = [
    [1, "Quadrados Perfeitos"],
    [2, "Primos Gêmeos"],
    [3, "Mersenne"],
    [4, "Fermat"],
    [5, "Goldbath"],
]


n_processamentos = 0
count_ja_processado = 0
processamento_contador = False

printar = True

def getVersao():
    url = url_global + 'api/versao'
    res = requests.post(url)
    return res.text

def verificarAtualizacao():
        resultadoGetVersao = getVersao()
        if(versao != resultadoGetVersao):
            print("\n\n-> !!CLIENTE DESATUALIZADO!!;")
            print("Por favor, baixe a nova versão ou requisite o administrador;")
            print("Download da nova varsão: " + url_global + "download")
            print("Contato: mateusbaltazar9@gmail.com")

            print("Versão desatualizada desse programa: " + versao + ";")
            print("Versão atualizada desse programa: " + resultadoGetVersao + ";\n")
            exit()


def proc_start(thread_num):

    print("Iniciando thread {:10d}".format(threading.get_native_id()))
    global count_ja_processado
    while True:
        if processamento_contador:
            if count_ja_processado >= n_processamentos:
                print(f"O limite de processos finalizados que o usuário definiu foi atingido! [{n_processamentos} processos concluídos]")
                exit()

        verificarAtualizacao()

        # Chamada de processamento de vários tipos de trabalhos
        resultado_processamento = False
        if(id_prob == 1):
            resultado_processamento = trabalhar_prob1(url_global, id_prob, diretorio_dados, funcao_lib)
        elif(id_prob == 2):
            resultado_processamento = trabalhar_prob2(url_global, id_prob, diretorio_dados, funcao_lib)

        if(not resultado_processamento):
            print("[{:10d}] Erro ao tentar processar. Tentando novamente em 10 segundos.\nPor Favor, informe esse erro ao administrador.".format(threading.get_native_id()))
            time.sleep(10)
        else:
            count_ja_processado += 1


# ---------------------------------------------------

for i in range(len(sys.argv)):
    if sys.argv[i] == "-h":
        print("\n>> Argumentos:")
        # print("-t <valor>  | para definir o número de threads ")
        # print("!!!Ainda não estão funcionando!!!")
        print("[-h] para mostrar o menu de ajuda")
        print("[-probs para mostrar todos os problemas que podes contribuir]")
        print("[-prob para selecionar o id do problema que deseja processar]")
        print("\t veja os ids usando o parâmetro -probs")
        print("[-v] para mostrar a versão desse programa")
        print("[-n <número de processos>] para indicar a quantidade de processos")
        print("[-t <número de threads>] para indicar a quantidade de threads")
        print("[-d <diretório dos dados>] para indicar das listas de dados")
        print("[-q] modo silencioso")
        print("[-host] para indicar o servidor (opcional)")
        print("\t exemplo: -host http://localhost/")

        # print("[-c <nome>] para indicar o nome do cliente irá processar")
        # print("\t Atenção: CaseSensitive; [Alfredo é diferente de alfredo]")

        print("")
        print("Para criar um usuário, contate o administrador [TEMPORÁRIO]")
        print("Contato: mateusbaltazar9@gmail.com")
        print("!Obrigado por ajudar!")
        print("Site:", url_global)
        print()
        exit()

    # if sys.argv[i] == "-c":
    #     nomeCliente = str(sys.argv[i + 1])
    #     if not (nomeCliente.isalpha()):
    #         print("\n-> !!Seu nome deve conter apenas letras!!\n")
    #         exit()

    if sys.argv[i] == "-probs":
        print("\nID e nome dos problemas que você pode contribuir! =D\n")
        for i in nomes_prob:
            print("-> ID:[" + str(i[0]) + "]; Nome:[" + str(i[1]) + "]; URL:[" + str(url_global) + "problemas/" + str(i[0]) + ']')
        print()
        exit()

    if sys.argv[i] == "-prob":
        id_prob = int(sys.argv[i + 1])
        if(id_prob not in nomes_prob[0]):
            print("\nO id do problema selecionado não existe!")
            print("Favor, use o parametro -probs para visualizar todos os problemas ativos.")
            print("Na dúvida, utilizar o parâmetro -h.\n")
            exit()
        for k in nomes_prob:
            if(str(k[0]) == str(id_prob)):
                print("Você selecionou o problema [" + str(k[1]) + "] para processar!\n")
                break

    if sys.argv[i] == "-host":
        url_global = str(sys.argv[i + 1])

    if sys.argv[i] == "-n":
        if ((i + 1 < len(sys.argv))) and str(sys.argv[i + 1]).isnumeric():
            n_processamentos = int(sys.argv[i + 1])
            processamento_contador = True
        else:
            print("\nNúmero de processamentos invalido")
            exit()

    if sys.argv[i] == "-v":
        versao_mais_atual = getVersao()
        print("\n-> Versão Mais atual: " + versao_mais_atual)
        print("-> Versão desse programa: " + versao)

        if(versao_mais_atual != versao):
            verificarAtualizacao()
        else:
            print("\nTudo certinho e atualizado! =)\n")

        exit()

    if sys.argv[i] == "-t":
        if ((i + 1 < len(sys.argv))) and str(sys.argv[i + 1]).isnumeric():
            nn = int(sys.argv[i + 1])
            if nn > 0:
                numeroDeThreads = nn
        else:
            print("\nNúmero de processamentos invalido")
            exit()

    if sys.argv[i] == "-d":
        if ((i + 1 < len(sys.argv))) and str(sys.argv[i + 1]).isalpha():
            diretorio_dados = str(sys.argv[i + 1])
        else:
            print("\nDiretório Inválido")
            exit()

    if sys.argv[i] == "-q":
        printar = False

time.sleep(1/4)
print("--------------------------------------")
time.sleep(1/4)
print("   mmm  mmmmm  mmmmm  mmmm  ")
time.sleep(1/4)
print(" m\"   \" #   \"#   #    #   \"m")
time.sleep(1/4)
print(" #   mm #mmmm\"   #    #    #")
time.sleep(1/4)
print(" #    # #   \"m   #    #    #")
time.sleep(1/4)
print("  \"mmm\" #    \" mm#mm  #mmm\" ")
time.sleep(1/4)
print("--------------------------------------")
time.sleep(1/5)
print("by: MBaltz && Sekva | (GITHUB)")
time.sleep(1/3)
print("--------------------------------------")
time.sleep(1/2)

print("-> Obrigado por contribuir! <-")
time.sleep(1/3)
print("--------------------------------------")
if(nomeCliente != "user"):
    time.sleep(1/3)
    print("Está ajudando bastante, " + nomeCliente + "! S2")
    time.sleep(1/2)
    print("--------------------------------------")
time.sleep(1/2)

# Só pra carregar a lista dos primos antes de iniciar as threads
args = ""
#TODO: arrumar o apontamento
diretorio_dados_carregamento = diretorio_dados + 'Lista_A.list'
funcao_lib(c_short(0), c_char_p(args.encode("utf-8")), c_char_p(diretorio_dados_carregamento.encode("utf-8")))

for i in range(numeroDeThreads):
    #TODO: ir passando um id melhor pra todas as threads, inclusive pro c++
    threading.Thread(target=proc_start, args=[i]).start()
    time.sleep(2)
