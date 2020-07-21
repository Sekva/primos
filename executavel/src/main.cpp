#include "main.hpp"
#include "global.hpp"
#include <string>
void nop(Num _a, Num _b, Num _c, Num _d) {
  printf("nop\n");
}

std::vector<unsigned long> primos;

void carregar_primos(char* nome_arquivo)  {
  printf("Carregando lista de primos...\n");
  std::ifstream infile(nome_arquivo);
  printf("asdasdad --  %s\n", nome_arquivo);
  if(!infile) {
      exit(5);
  }
  std::string line;
  while (std::getline(infile, line)) {
    std::istringstream iss(line);
    unsigned long v;
    if (!(iss >> v)) { break; }
    primos.push_back(v);
  }
  printf("São %ld primos q\n", primos.size());
}

char* preparar_problema1(char* args) {
    //transforma os args na estrutura do problema
    //chama o problema
    //return problema_1(params...);
    return (char*) "1"; //return temporario
}
char* preparar_problema2(char* args) {return (char*) "2";}
char* preparar_problema3(char* args) {return (char*) "3";}
char* preparar_problema4(char* args) {return (char*) "4";}
char* preparar_problema5(char* args) {return (char*) "5";}
char* preparar_problema6(char* args) {return (char*) "6";}
char* preparar_problema7(char* args) {return (char*) "7";}

char* prog(unsigned short problema, char* args, char* arquivo_primos) {

  if(arquivo_primos) {
    carregar_primos(arquivo_primos);
  } else {
    printf("Passe 1 arquivo com os numeros\n");
    return (char*)"nop";
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

  return (char*) "nop";

}
