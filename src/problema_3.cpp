#include "global.hpp"
extern std::vector<unsigned long> primos;

void problema_3() {
  printf("Rodando problema_3... Problema inverso de Fermat\n");

  unsigned long p;
  unsigned long tamanho_vetor = primos.size();
  unsigned long comecar_da_posicao = 0;
  for(unsigned long int i = comecar_da_posicao; i < tamanho_vetor; i++) {
      p = primos[i];
      long double n = log2l(log2l(p-1));
      if(e_inteiro(n)) {
          printf("p: %ld, n: %Lf\n", p, n);
      }
  }
}
