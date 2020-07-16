#include "global.hpp"
extern std::vector<unsigned long> primos;

void problema_1(
        unsigned long indice_min_p,
        unsigned long indice_max_p,
        unsigned long indice_min_q,
        unsigned long indice_max_q) {


  printf("Rodando problema_1... (p+q)² + pq == a², a inteiro\n");

  unsigned long p, q, resultado;
  for(unsigned long i = indice_min_p; i <= indice_max_p; i++) {
    p = primos[i];
    for(unsigned long k = indice_min_q; k <= indice_max_q; k++) {
      q = primos[k];
      resultado = pow(p+q, 2) + p*q; //aux = pow(p, 2) + 3*p*q + pow(q, 2);
      unsigned long a = e_quadrado_perfeito(resultado);
      if(a != 0) { //Se a for 0 é pq resultado não é quadrado perfeito
        printf("p: %ld, q: %ld, a²:%ld, a: %ld\n", p, q, resultado, a);
      }
    }
  }
}
