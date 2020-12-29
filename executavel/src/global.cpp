#include "global.hpp"

int e_primo(unsigned long n) {
  if (n <= 1) return 0;
  for (unsigned long i = 2; i < n; i++) {
    if (n % i == 0)  return 0;
  }
  return 1;
}

unsigned long e_quadrado_perfeito(unsigned long num) {
  if (num < 0) return 0;
  if (num == 1) return 1;
  unsigned long i = 2;
  unsigned long j = num;
  while (i <= j) {
    unsigned long k = i + (j - i) / 2;
    if (k * k == num) return k;
    if (k * k > num) {
      j = k - 1;
    } else {
      i = k + 1;
    }
  }
  return 0;
}

int e_inteiro(long double num) {
  return roundl(num) == num;
}

// Ver Fonte: https://stackoverflow.com/a/60820394/9265407
double log_dois(mpz_t x) {
    signed long int ex;
    const double di = mpz_get_d_2exp(&ex, x);
    // std::cout << di << " " << (double) ex << " log(di):" << log2(di) << std::endl;
    // return log2(di) + log2(2) * (double) ex; // "Generalizada (precisa entender melhor)"
    return log2(di) + (double) ex; // Específico pra log2
}
