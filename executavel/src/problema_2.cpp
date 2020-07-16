#include "global.hpp"
extern std::vector<unsigned long> primos;

void problema_2(
        unsigned long indice_min_p,
        unsigned long indice_max_p,
        unsigned long indice_min_q,
        unsigned long indice_max_q) {

  printf("Rodando problema_2... Primos gemeos grau n\n");

  long grau_gemeo = 2;

  signed long p, q, resultado;
  for(unsigned long i = indice_min_p; i < indice_max_p; i++) {
    p = primos[i];
    for(unsigned long k = indice_min_q; k < indice_max_q; k++) {
      q = primos[k];
      printf("\r p: %ld, q:%ld", p, q);
      signed long valor = (signed long) (p - q);
      resultado = abs(valor);
      if(resultado == grau_gemeo) {
        printf("p: %ld, q: %ld, grau_gemeo: %ld\n", p, q, resultado);
      }
    }
  }



}
