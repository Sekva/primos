#include "main.hpp"
#include "global.hpp"
#include <gmpxx.h>
#include <string>
void nop(Num _a, Num _b, Num _c, Num _d) {
  printf("nop\n");
}


std::vector<std::string> explode(const std::string& str, const char& ch) {
    std::string next;
    std::vector<std::string> result;

    // For each character in the string
    for (std::string::const_iterator it = str.begin(); it != str.end(); it++) {
        // If we've hit the terminal character
        if (*it == ch) {
            // If we have some characters accumulated
            if (!next.empty()) {
                // Add them to the result vector
                result.push_back(next);
                next.clear();
            }
        } else {
            // Accumulate the next character into the sequence
            next += *it;
        }
    }
    if (!next.empty())
         result.push_back(next);
    return result;
}



std::vector<mpz_class> primos;
char ja_foi_carregado = 0;

void carregar_primos(char* nome_arquivo)  {
    if(ja_foi_carregado) { return; }
  printf("Carregando lista de primos...\n");
  std::ifstream infile(nome_arquivo);
  printf("Usando o arquivo %s\n", nome_arquivo);
  if(!infile) {
      exit(5);
  }
  std::string line;
  while (std::getline(infile, line)) {
    std::istringstream iss(line);
    std::string v;
    if (!(iss >> v)) { break; }
    primos.push_back(mpz_class(v));
  }
  ja_foi_carregado = 1;
  printf("São %ld primos...\n", primos.size());
}

char* preparar_problema1(char* args) {

    std::string args_str(args);
    std::vector<std::string> vec_args = explode(args_str, '/');

    unsigned long min_p = std::stoull(vec_args[0]);
    unsigned long max_p = std::stoull(vec_args[1]);
    unsigned long min_q = std::stoull(vec_args[2]);
    unsigned long max_q = std::stoull(vec_args[3]);

    return problema_1(min_p, max_p, min_q, max_q);
}

char* preparar_problema2(char* args) {return (char*) "2";}
char* preparar_problema3(char* args) {return (char*) "3";}
char* preparar_problema4(char* args) {return (char*) "4";}
char* preparar_problema5(char* args) {return (char*) "5";}
char* preparar_problema6(char* args) {return (char*) "6";}
char* preparar_problema7(char* args) {return (char*) "7";}

char* prog(unsigned short problema, char* args, char* arquivo_primos) {


    char* nop_ret = (char*) calloc(sizeof(char), 4);
    nop_ret[0] = 'n';
    nop_ret[1] = 'o';
    nop_ret[2] = 'p';
    nop_ret[3] = '\0';

  if(arquivo_primos) {
    carregar_primos(arquivo_primos);
  } else {
    printf("Passe 1 arquivo com os numeros\n");
    return nop_ret;
  }

  switch (problema) {
      case 1:
          return preparar_problema1(args);
      case 2:
          return preparar_problema2(args);
      case 3:
          return preparar_problema3(args);
      case 4:
          return preparar_problema4(args);
      case 5:
          return preparar_problema5(args);
      case 6:
          return preparar_problema6(args);
      case 7:
          return preparar_problema7(args);
      default:
          break;
  }
  return nop_ret;

}
