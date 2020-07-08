#include "main.hpp"
#include "global.hpp"

void nop(void) {
  printf("nop\n");
}

std::vector<unsigned long> primos;

void carregar_primos(const char* nome_arquivo)  {
  printf("Carregando lista de primos...\n");
  std::ifstream infile(nome_arquivo);
  std::string line;
  while (std::getline(infile, line)) {
    std::istringstream iss(line);
    unsigned long v;
    if (!(iss >> v)) { break; }
    primos.push_back(v);
  }
  printf("São %ld primos\n", primos.size());
}

int main(int argc, char** argv) {
  argc--; argv++;
  void (*funcao)(void) = &nop;

  // escolher a funcao problema
  printf("Escolha o problema:\n");
  printf("  a) problema_1\n");
  printf("  b) problema_2\n");
  printf("  c) problema_3\n");
  printf("  d) problema_4\n");
  printf("  e) problema_5\n");
  printf("  f) problema_6\n");
  printf("  g) problema_7\n");
  char escolha;
  escolha = getchar();
  //escolha = 'c';

  switch (escolha) {
    case 'a': funcao = &problema_1; break;
    case 'b': funcao = &problema_2; break;
    case 'c': funcao = &problema_3; break;
    case 'd': funcao = &problema_4; break;
    case 'e': funcao = &problema_5; break;
    case 'f': funcao = &problema_6; break;
    case 'g': funcao = &problema_7; break;
    default: break;
  }

  if(argv[0]) {
    carregar_primos(argv[0]);
  } else {
    printf("Passe o arquivo com os numeros\n");
    return 1;
  }


  funcao();
  return 0;

}
