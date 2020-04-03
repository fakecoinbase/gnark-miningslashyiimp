#ifndef RFV2_H
#define RFV2_H

#ifdef __cplusplus
extern "C" {
#endif

#include <stdint.h>

void rfv2_hash_yiimp(const char* input, char* output, uint32_t len);

#ifdef __cplusplus
}
#endif

#endif
