#!/bin/python3




from ctypes import *
libtqp = CDLL("../build/libtqp.so")
fn = libtqp._Z4progtPcS_
fn.restype = c_char_p

args = str(0) + "/" + str(14000000)
diretorio = "/home/baltz/lista_pequena.list"
diretorio = "/home/baltz/Documentos/UAG/Projeto-Pesquisa-2019/primos/grid/cliente/dados/Lista_A.list"

p = fn(c_short(3), c_char_p(args.encode("utf-8")), c_char_p(diretorio.encode("utf-8")))
print(p)
