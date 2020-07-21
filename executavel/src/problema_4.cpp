#include "global.hpp"
extern std::vector<unsigned long> primos;

void problema_4(
        unsigned long indice_min_p,
        unsigned long indice_max_p,
        unsigned long indice_min_q,
        unsigned long indice_max_q) {

  printf("Rodando problema_3... Problema inverso de Mersenne\n");

  unsigned long p;
  for(unsigned long int i = indice_min_p; i < indice_max_p; i++) {
      p = primos[i];
      long double n = log2l(p+1);
      if(e_inteiro(n)) {
          printf("p: %ld, n: %Lf\n", p, n);
      }
  }

  unsigned long q;
  for(unsigned long int i = indice_min_q; i < indice_max_q; i++) {
      q = primos[i];
      long double n = log2l(q+1);
      if(e_inteiro(n)) {
          printf("q: %ld, n: %Lf\n", q, n);
      }
  }
}
