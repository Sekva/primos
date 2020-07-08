#include "global.hpp"
extern std::vector<unsigned long> primos_p;
extern std::vector<unsigned long> primos_q;

void problema_1() {
  printf("Rodando problema_1... (p+q)² + pq == a²\n");

  unsigned long p, q, resultado;
  unsigned long tamanho_vetor_p = primos_p.size();
  unsigned long tamanho_vetor_q = primos_q.size();
  for(unsigned long i = 0; i < tamanho_vetor_p; i++) {
    p = primos_p[i];
    for(unsigned long k = 0; k < tamanho_vetor_q; k++) {
      q = primos_q[k];
      resultado = pow(p+q, 2) + p*q; //aux = pow(p, 2) + 3*p*q + pow(q, 2);
      unsigned long a = e_quadrado_perfeito(resultado);
      if(a != 0) { //Se a for 0 é pq resultado não é quadrado perfeito
        printf("p: %ld, q: %ld, a²:%ld, a: %ld\n", p, q, resultado, a);
      }
    }
  }
}
