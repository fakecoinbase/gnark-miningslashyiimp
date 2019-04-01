/*-
 * Copyright 2018 Cryply team
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
 * OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 *
 * This file was originally written by Cryply team as part of the Cryply
 * coin.
 */
#include <stdint.h>
#include <string.h>
#include <stdio.h>

#include "yespower.h"
#include "sysendian.h"



static const yespower_params_t v1 = {YESPOWER_0_5, 4096, 16, "Client Key", 10};

static const yespower_params_t v2 = {YESPOWER_0_9, 2048, 32, NULL, 0};

static const yespower_params_t v3 = {YESPOWER_0_9, 4096, 16, NULL, 0};


void yespower_hash( const char *input, char *output, uint32_t len )
{
   yespower_tls( (yespower_binary_t*)input, len, &v2, (yespower_binary_t*)output );
}

void yespowerR16_hash( const char *input, char *output, uint32_t len )
{
   yespower_tls( (yespower_binary_t*)input, len, &v3, (yespower_binary_t*)output );
}


