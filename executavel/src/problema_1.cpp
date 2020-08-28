#include "global.hpp"
#include <gmpxx.h>
extern std::vector<mpz_class> primos;

char* problema_1(
        unsigned long indice_min_p,
        unsigned long indice_max_p,
        unsigned long indice_min_q,
        unsigned long indice_max_q) {

  std::stringstream ss;
  ss << std::this_thread::get_id();
  uint64_t id = std::stoull(ss.str());
  printf("[%10lu] Rodando problema_1... (p+q)² + pq == a², a inteiro, p=%ld:%ld, q=%ld:%ld\n", id, indice_min_p, indice_max_p, indice_min_q, indice_max_q);
  std::ostringstream stringStream;

  mpz_class p, q, resultado, parte_1, parte_2, quadrado;
  for(unsigned long i = indice_min_p; i <= indice_max_p; i++) {
    p = primos[i];
    for(unsigned long k = indice_min_q; k <= indice_max_q; k++) {
      q = primos[k];

      mpz_class soma = p + q;
      parte_1 = soma * soma;

      parte_2 = p * q;

      resultado = parte_1 + parte_2;

      int a = mpz_perfect_square_p(resultado.get_mpz_t());
      if(a != 0) { //Se a for 0 é pq resultado não é quadrado perfeito
          //std::cout << "p: " << p << ", q: " << q << ", a²: " << resultado << "\n";
          stringStream << p << "/" << q << "/" << resultado << "\n";
      }
    }
  }

  std::string str_return = stringStream.str();
  char* char_p_ret = (char*) calloc(str_return.length()+1 , sizeof(char));
  for(int i = 0; i < (int) str_return.length(); i++) {
      char_p_ret[i] = str_return[i];
  }
  char_p_ret[str_return.length()+1] = '\0';
  return char_p_ret;
}
