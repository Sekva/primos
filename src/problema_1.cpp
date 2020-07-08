#include "global.hpp"
extern std::vector<unsigned long> primos;

void problema_1() {
  printf("Rodando problema_1... (p+q)² + pq == a²\n");

  unsigned long p, q, resultado;
  unsigned long tamanho_vetor = primos.size();
  unsigned long comecar_da_posicao = 1;
  for(unsigned long i = comecar_da_posicao; i < tamanho_vetor; i++) {
    p = primos[i];
    for(signed long k = (i-1); k != -1; k--) {
      q = primos[k];
      resultado = pow(p+q, 2) + p*q; //aux = pow(p, 2) + 3*p*q + pow(q, 2);
      unsigned long a = e_quadrado_perfeito(resultado);
      if(a != 0) { //Se a for 0 é pq resultado não é quadrado perfeito
        printf("p: %ld, q: %ld, a²:%ld, a: %ld\n", p, q, resultado, a);
      }
    }
  }
}
