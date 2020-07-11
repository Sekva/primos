#include "global.hpp"
extern std::vector<unsigned long> primos_p;
extern std::vector<unsigned long> primos_q;

void problema_2() {
  printf("Rodando problema_2... Primos gemeos grau n\n");

  /* O loop de q tem q ser reverso, pq a chance do par de p, q, ta perto de p é
  *  bem alta se o grau for pequeno
  */


  /* As listas são ordenadas, então se a diferença dos 2 primeiros elementos
   * das duas listas for maior que o grau, então não tem porque fazer
   */

  //TODO: pensar nisso e/ou talvez voltar pra uma unica lista

  long grau_gemeo = 2;

  signed long p, q, resultado;
  unsigned long tamanho_vetor_p = primos_p.size();
  unsigned long tamanho_vetor_q = primos_q.size();
  for(unsigned long i = 0; i < tamanho_vetor_p; i++) {
    p = primos_p[i];
    for(unsigned long k = 0; k < tamanho_vetor_q; k++) {
      q = primos_q[k];
      printf("\r p: %ld, q:%ld", p, q);
      signed long valor = (signed long) (p - q);
      resultado = abs(valor);
      if(resultado == grau_gemeo) {
        printf("p: %ld, q: %ld, grau_gemeo: %ld\n", p, q, resultado);
      }
    }
  }



}
