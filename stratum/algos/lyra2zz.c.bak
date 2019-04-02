#include <stdlib.h>
#include <stdint.h>
#include <string.h>
#include <stdio.h>

#include "lyra2zz.h"

#include <sha3/sph_blake.h>

#define _ALIGN(x) __attribute__ ((aligned(x)))

extern uint64_t lyra2z_height;

void lyra2zz_hash(const char* input, char* output, uint32_t len)
{
    sph_blake256_context ctx_blake;

    uint32_t hashA[8], hashB[8];

    sph_blake256_init(&ctx_blake);
    sph_blake256 (&ctx_blake, input, 112);
    sph_blake256_close (&ctx_blake, hashA);

	LYRA2ZZ(hashB, 32, hashA, 32, hashA, 32, 8, 8, 8);

	memcpy(output, hashB, 32);
}
