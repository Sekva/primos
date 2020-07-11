
# TODO: Fazer com que o script possibilite a
# utilização de várias threads para generalizar
# e utilizar isso em programas distintos


import requests
import sys
import os
import subprocess
import time
import threading

versao = "1.0.2"
numeroDeThreads = 1
nomeCliente = "user"


url_global = "http://173.82.114.155/"


n_processamentos = 0
ja_processado = 0
processamento_contado = False


printar = True

def getVersao():
    url = url_global + 'versao.php'
    res = requests.post(url)
    return res.text


def verificarAtualizacao():
        resultadoAttProcessando = getVersao()
        if(versao != resultadoAttProcessando):
            print("\n\n-> !!CLIENTE DESATUALIZADO!!;")
            print("Por favor, baixe a nova versão ou requisite o administrador;")
            print("Download da nova varsão: " + url_global + "download")
            print("Contato: mateusbaltazar9@gmail.com")

            print("Versão desatualizada desse programa: " + versao + ";")
            print("Versão atualizada desse programa: " + resultadoAttProcessando.text + ";")

            exit()


def processar(resultado, thread_num):
    global printar
    if printar: print("Processando...");

    a = []
    a = resultado.json()
    b = dict(a[4])

    url = url_global + 'ConfigCentrais/enviar.php'
    conteudoEnvio = {'atualizacaoProcessando': '', 'id': a[1]}
    resultadoAttProcessando = requests.post(url, data = conteudoEnvio)
    # print(resultadoAttProcessando.text)

    # TODO: Mudar nome de arquivo para um randômico e passar como parâmetro para programa

    # Escreve em arquivo a quantidade de corpos, iteracoes e as suas coordenadas
    nome_arquivo = "saida_" + str(thread_num) + ".saida"
    file = open(nome_arquivo,"w+")

    # TODO: @mecanica Mostrar tempo processando aquele processo
    # TODO: @mecanica Apagar arquivo de saida aapós uso (NO COMPILADO)
    #           Atualmente isso está sendo feito no .py, mas n funciona como deveria

    file.write(str(a[2][0]) + " "  + str(a[3][0]))
    for i in b.values():
        file.write("\n")
        file.write(str(i[0]))
        file.write(" ")
        file.write(str(i[1]))

    # Consumir tempo para fechar o arquivo
    for i in range(1000):
        i = i

    file.close()

    re = subprocess.check_output(["./a.out", str(thread_num)])


    # Consumir tempo para apagar arquivo
    for i in range(10000):
        i = i

    if os.path.isfile(nome_arquivo):
        os.remove(nome_arquivo)



    # Trata a saida do arquivo compilado
    reSplit = str(re).split("\\n")
    # print(reSplit)
    reSplit[0] = reSplit[0][2::]
    reSplit.pop()
    if printar: print("Dados processados:");
    for i in reSplit:
        if printar: print(i)


    count = 1
    novasCoordenadas = "{"
    for i in reSplit:
        aux = i.split(', ')
        novasCoordenadas = str(novasCoordenadas) + "\"" + str(count) + "\":["
        novasCoordenadas = str(novasCoordenadas) + str(aux[0]) + "," + str(aux[1]) + "]"
        if(count < len(reSplit)):
            novasCoordenadas = str(novasCoordenadas) + ","
        count += 1


    novasCoordenadas = str(novasCoordenadas) +  "}"
    # print(novasCoordenadas)

    url = url_global + 'ConfigCentrais/enviar.php'
    conteudoEnviar = {'novosDadosProcessados': '', 'id': a[1], 'novasCoordenadas': novasCoordenadas, 'nomeCliente': str(nomeCliente)}
    resultadoAttProcessando = requests.post(url, data = conteudoEnviar)
    if printar: print(resultadoAttProcessando.text)


def proc_start(thread_num):

    global ja_processado
    while True:

        if processamento_contado:
            if ja_processado >= n_processamentos:
                exit()

        verificarAtualizacao()

        url = url_global + 'ConfigCentrais/requisitar.php'

        resultado = requests.post(url)

        if(resultado.text[4] == "o" and resultado.text[5] == "k"):
            if printar: print("\nRequisitando um novo Processo! thread " + str(thread_num))
            time.sleep(1/2)
            if printar: print("[    ]", end="\r")
            time.sleep(1/3)
            if printar: print("[.   ]", end="\r")
            time.sleep(1/3)
            if printar: print("[..  ]", end="\r")
            time.sleep(1/3)
            if printar: print("[... ]", end="\r")
            time.sleep(1/2)
            if printar: print("[....]")
            time.sleep(1/2)
            processar(resultado, thread_num)

            ja_processado = ja_processado + 1

        else:
            print("FALHA!", end="\r")
            time.sleep(1)
            print("Nenhum dado foi obtido na thread " + str(thread_num) +  ", tentando novamente...")
            time.sleep(1/2)
            if printar: print("[    ]", end="\r")
            time.sleep(1/3)
            if printar: print("[.   ]", end="\r")
            time.sleep(1/2)
            if printar: print("[..  ]", end="\r")
            time.sleep(1/3)
            if printar: print("[... ]", end="\r")
            time.sleep(1/2)
            if printar: print("[....]")
            time.sleep(1/2)


# ---------------------------------------------------

for i in range(len(sys.argv)):
    if sys.argv[i] == "-h":
        print("\n>> Argumentos:")
        # print("-t <valor>  | para definir o número de threads ")
        # print("!!!Ainda não estão funcionando!!!")
        print("[-h] para mostrar o menu de ajuda")
        print("[-v] para mostrar a versão desse programa")
        print("[-c <nome>] para indicar o nome do cliente irá processar")
        print("\t Atenção: CaseSensitive; [Alfredo é diferente de alfredo]")
        print("[-n <número de processos>] para indicar a quantidade de processos")
        print("[-t <número de threads>] para indicar a quantidade de threads")
        print("[-q] modo silencioso")
        print("[-host] para indicar o servidor (opcional)")
        print("\t exemplo: -host http://localhost/")
        print("")
        print("Para criar um usuário, contate o administrador [TEMPORÁRIO]")
        print("Contato: mateusbaltazar9@gmail.com")
        print("!Obrigado por ajudar!")
        print("Site: ", url_global)
        print()
        exit()
    if sys.argv[i] == "-c":
        nomeCliente = str(sys.argv[i + 1])
        if not (nomeCliente.isalpha()):
            print("\n-> !!Seu nome deve conter apenas letras!!\n")
            exit()
    if sys.argv[i] == "-host":
        url_global = str(sys.argv[i + 1])

    if sys.argv[i] == "-n":
        if ((i + 1 < len(sys.argv))) and str(sys.argv[i + 1]).isnumeric():
            n_processamentos = int(sys.argv[i + 1])
            processamento_contado = True
        else:
            print("\nNúmero de processamentos invalido")
            exit()

    if sys.argv[i] == "-v":
        print("\nVersão: " + getVersao() + "\n")
        exit()

    if sys.argv[i] == "-t":
        if ((i + 1 < len(sys.argv))) and str(sys.argv[i + 1]).isnumeric():
            nn = int(sys.argv[i + 1])
            if nn > 0:
                numeroDeThreads = nn
        else:
            print("\nNúmero de processamentos invalido")
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

for i in range(numeroDeThreads):
    print("Iniciando thread " + str(i))
    threading.Thread(target=proc_start, args=[i]).start()
    time.sleep(2)
