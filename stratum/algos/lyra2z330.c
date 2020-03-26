#include <stdlib.h>
#include <stdint.h>
#include <string.h>
#include <stdio.h>

#include "Lyra2-z330.h"

#include <sha3/sph_blake.h>

#define _ALIGN(x) __attribute__ ((aligned(x)))

extern uint64_t lyra2z330_height;

void lyra2z330_hash(const char* input, char* output, uint32_t len)
{
	uint32_t _ALIGN(256) hashB[16], hash[16];
	sph_blake256_context ctx_blake;

	sph_blake256_set_rounds(14);

	sph_blake256_init(&ctx_blake);
	sph_blake256(&ctx_blake, input, len);
	sph_blake256_close(&ctx_blake, hashB);

	lyra2z330(hash, 32, hashB, 32, input, 32, 80, 80, 80);

	memcpy(output, hash, 32);
}

