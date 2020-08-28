#include "global.hpp"
#include <gmp.h>
extern std::vector<mpz_class> primos;

char* problema_2(
        unsigned long indice_min,
        unsigned long indice_max,
        unsigned long k) {

  std::stringstream ss;
  ss << std::this_thread::get_id();
  uint64_t id = std::stoull(ss.str());
  printf("[%10lu] Rodando problema_2... Primos gemeos grau n=%ld\n", id, k);

  mpz_class p, q, k_mpz, diff;
  mpz_set_ui(k_mpz.get_mpz_t(), k);

  std::ostringstream stringStream;

  for(unsigned long idx = indice_min; idx < indice_min + indice_max; idx++) {

      p = primos[idx];
      q = primos[idx + 1];
      diff = q - p;

      // Como a lista é ordenada, então diff é sempre positivo
      if(diff == k_mpz) {
          //std::cout << "p: " << p << ", q: " << q << ", q-p: " << diff << ", p_i: " << idx << ", q_i: " << idx+1 << "\n";
          stringStream << p << "/" << q << "/" << diff << "/" << idx << "/" << idx+1 << "\n";
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
