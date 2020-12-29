#include "global.hpp"
extern std::vector<mpz_class> primos;

#include <string>
char* problema_3(
  unsigned long indice_min_p,
  unsigned long indice_max_p) {

  std::ostringstream stringStream;

  printf("Rodando problema_3... Problema inverso de Mersenne\n");
  // q = log2(p + 1)

  mpz_class p;
  // Para a verificação de 'n é primo?', como a lista de primos está ordenada,
  // a busca por n dentro do vetor de primos está sendo otimizado ao fazer
  // a procura a partir do ultimo primo mais próximo de n da iteração anterior.
  unsigned long ultimo_i_q_testado = 0;
  for(unsigned long int i = indice_min_p; i < indice_max_p; i++) {
    p = primos[i];
    p = p + 1; // p + 1
    double n = log_dois(p.get_mpz_t()); // log2(p + 1)
    if(e_inteiro(n)) { // Se for um valor inteiro
      mpz_class q_aux;
      for( ; (q_aux = primos[ultimo_i_q_testado]) <= n; ultimo_i_q_testado++) {
        if(n == q_aux) { // Se for primo
          stringStream << p - 1 << "/" << n << "\n";
        }
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
