#!/bin/python3

from ctypes import *
libtqp = CDLL("../build/libtqp.so")
fn = libtqp._Z4progtPcS_
fn.restype = c_char_p
p = fn(c_short(1), c_char_p("nada".encode("utf-8")), c_char_p("../../listas/arquivinho".encode("utf-8")))
print(p)

