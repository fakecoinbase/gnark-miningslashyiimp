#include <stdlib.h>
#include <stdint.h>
#include <string.h>
#include <stdio.h>

#include "rfv2/rfv2.h"

void rfv2_hash_yiimp(const char* input, char* output, uint32_t len)
{
    char hash[64];
    rfv2_hash(hash, input, len, NULL, NULL);
    memcpy(output, &hash, 32);
}
