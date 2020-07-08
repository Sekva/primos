#include "global.hpp"
extern std::vector<unsigned long> primos_p;
extern std::vector<unsigned long> primos_q;

void problema_3() {
  printf("Rodando problema_3... Problema inverso de Fermat\n");

  unsigned long p;
  unsigned long tamanho_vetor = primos_p.size();
  for(unsigned long int i = 0; i < tamanho_vetor; i++) {
      p = primos_p[i];
      long double n = log2l(log2l(p-1));
      if(e_inteiro(n)) {
          printf("p: %ld, n: %Lf\n", p, n);
      }
  }

  unsigned long q;
  tamanho_vetor = primos_q.size();
  for(unsigned long int i = 0; i < tamanho_vetor; i++) {
      q = primos_q[i];
      long double n = log2l(log2l(q-1));
      if(e_inteiro(n)) {
          printf("q: %ld, n: %Lf\n", q, n);
      }
  }

}
