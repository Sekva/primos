#include <cstdio>
#include <iostream>
#include <cmath>
#include <vector>
#include <random>
#include <chrono>
#include <iomanip> // Para setar a precisao do cout

#include <string>
#include <sstream>
#include <fstream>

typedef long double Num;
struct vetor;
typedef struct vetor Vetor;

struct vetor {
    Num x;
    Num y;
    static Vetor novo(Num x1, Num x2) {
        Vetor v;
        v.x = x1;
        v.y = x2;
        return v;
    }
    Num norma() { return sqrt(pow(this->x, 2) + pow(this->y, 2)); }

    Num cubo_norma() { Num c = this-> norma(); return c * c * c; }
    Num cubo_norma_i() { return 1.0 / this->cubo_norma(); }

    inline Vetor operator+(Vetor a) {
        Vetor v;
        v.x = this->x + a.x;
        v.y = this->y + a.y;
        return v;
    }

    inline Vetor operator-(Vetor a) {
        Vetor v;
        v.x = this->x - a.x;
        v.y = this->y - a.y;
        return v;
    }

    void escalar(Num l) { this->x *= l; this->y *= l; }

    void print() { std::cout << std::setprecision(10) << this->x << ", " << this->y << "\n"; }

};


Num N = 4;
uint64_t quantTotalIteracoes = 100000;
uint64_t iteracaoAtual = 0;
std::vector<Vetor> pontos;



void lerArquivoCordenadas(std::string nomeArquivo) {
    std::ifstream myReadFile;
    //NOME DO ARQUIVO
    myReadFile.open(nomeArquivo);

    if (myReadFile.is_open()) {
        int count = 0;
        while (!myReadFile.eof()) {
            if(count < 1) {
                  myReadFile >> N >> quantTotalIteracoes;
            } else if(count < N + 1) {
                  Num var_x, var_y;
                  myReadFile >> var_x >> var_y;
                  pontos.push_back(Vetor::novo(var_x, var_y));
            } else {
                break;
            }
            count++;
        }

    }
    myReadFile.close();
    remove(nomeArquivo.c_str());
}


int main(int argc, char** argv) {

    std::string nomeArquivo = "saida_";
    nomeArquivo += std::string(argv[1]);
    nomeArquivo += ".saida";
    lerArquivoCordenadas(nomeArquivo);
    remove(nomeArquivo.c_str());

    //Mostra a configracao inicial
    // for(Num i = 0; i < N; i++) {
    //     pontos[i].print();
    // }

	// std::cout << "N: " << N << ", iteracoes: " << quantTotalIteracoes << std::endl;


    for(Num iteracaoAtual = 0; iteracaoAtual < quantTotalIteracoes; iteracaoAtual++) {
        // std::cout << "\r" << iteracaoAtual;
        for(Num j = 0; j < N; j++) {
            for(Num k = 0; k < N; k++) {
                if(k == j) { continue; }
                Vetor vv = pontos[j] - pontos[k];
                Num scl = vv.cubo_norma_i();
                vv.escalar(scl);

                pontos[j] = pontos[j] + vv;

            }
        }

    }

   //Saida apos as iteracoes (resultado)
   for(Num i = 0; i < N; i++) {
       pontos[i].print();
   }

    return 0;
}
