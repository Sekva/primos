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
