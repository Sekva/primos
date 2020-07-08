#include "global.hpp"
extern std::vector<unsigned long> primos;

void problema_2() {
  printf("Rodando problema_2... Primos gemeos grau n\n");

  /* O loop de q tem q ser reverso, pq a chance do par de p, q, ta perto de p é
  *  bem alta se o grau for pequeno
  */
  long grau_gemeo = 2;

  signed long p, q, resultado;
  unsigned long tamanho_vetor = primos.size();
  unsigned long comecar_da_posicao = 1;
  for(unsigned long i = comecar_da_posicao; i < tamanho_vetor; i++) {
    p = primos[i];
    for(signed long k = (i-1); k != -1; k--) {
      q = primos[k];
      signed long valor = (signed long) (p - q);
      resultado = abs(valor);
      if(resultado == grau_gemeo) {
        printf("p: %ld, q: %ld, grau_gemeo: %ld\n", p, q, resultado);
      }
    }
  }



}
