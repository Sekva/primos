#include "global.hpp"

extern std::vector<mpz_class> primos;

void problema_5(
        unsigned long indice_min_p,
        unsigned long indice_max_p,
        unsigned long indice_min_q,
        unsigned long indice_max_q) {

  printf("Rodando problema_5... Problema de Goldbach\n");
  printf("Ainda não feito com 2 indices, parando...\n");
  return;
    /*
  unsigned long p, q;
  unsigned long tamanho_vetor = primos.size();
  unsigned long comecar_da_posicao = 0;
  unsigned long max_par_achado = 6;
  unsigned long comecar_do_k = 0;
  unsigned long max_par_possivel = primos[tamanho_vetor - 1] + primos[tamanho_vetor - 1];
  unsigned long max_diff = 10;
  printf("Max par possivel: %ld\n", max_par_possivel);

  reset_loop:
  for(unsigned long int i = comecar_da_posicao; i < tamanho_vetor; i++) {
    p = primos[i];
    for(unsigned long int k = comecar_do_k; k < tamanho_vetor; k++) {
      q = primos[k];
      unsigned long soma = p + q;

      if (soma == max_par_achado) {
        printf("\rp: %ld, q: %ld, soma: %ld, k: %ld, max_diff: %ld\n", p, q, soma, k, max_diff);
        max_par_achado = max_par_achado + 2;
        signed long comecar = k - max_diff;
        if(comecar < 0) {
          comecar_do_k = 0;
        } else {
          comecar_do_k = (unsigned long) comecar;
        }
        goto reset_loop;
      }

      if(soma > max_par_achado) {
        break;
      }

      if (soma == max_par_possivel) {
        printf("foi tudo\n");
        return;
      }


    }
    printf("\rmax_diff: %ld, p: %ld", max_diff, p);

    if(p > max_par_achado) {
      max_diff = max_diff + 10;
      comecar_do_k = 0;
      goto reset_loop;
    }
  }
  */
}
