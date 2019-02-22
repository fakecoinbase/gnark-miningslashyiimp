
CC=gcc

#CFLAGS=-c -g -I /usr/include/mysql
#LDFLAGS=-g

CXXFLAGS = -O2 -I.. -march=native
CFLAGS= $(CXXFLAGS) -std=gnu99
LDFLAGS=-O2 -lgmp

SOURCES=a5a.c a5amath.c aergo.c allium.c argon2d.c argon2d/argon2.c argon2d/core.c argon2d/encoding.c argon2d/opt.c argon2d/thread.c argon2m.c SWIFFTX/SWIFFTX.c  /
	balloon.c bastion.c bcd.c binarium_hash_v1.c binarium_hash_v1/encryption/gost2015_kuznechik/shared/tables.c binarium_hash_v1/encryption/gost2015_kuznechik/SIMD.c /
	binarium_hash_v1/encryption/gost2015_kuznechik/SIMD_tables.c binarium_hash_v1/encryption/salsa20/salsa20.c binarium_hash_v1/encryption/three_fish/libskein_skein.cc /
	binarium_hash_v1/hashing/streebog/table/stribog.c binarium_hash_v1/hashing/whirlpool/byte_order.c binarium_hash_v1/hashing/whirlpool/whirlpool.c bitcore.c /
	blake2/blake2b.c blake2b.c blake2s.c blake.c blakecoin.c bmw.c c11.c dedal.c deep.c exosis.c fresh.c geek.c gost.c groestl.c hex.c hive.c hmq17.c hsr14.c /
	jha.c keccak.c lbk3.c lbry.c luffa.c Lyra2-z.c Lyra2-zz.c Lyra2.c lyra2re.c lyra2re3.c lyra2v2.c lyra2v3.c lyra2vc0ban.c lyra2z.c lyra2zz.c m7m.c magimath.cpp /
	neoscrypt.c nist5.c pentablake.c phi2.c phi1612.c phi.c pipehash.c polytimos.c pomelo.c quark.c qubit.c rainforest.c scrypt.c scryptn.c sha256-P.c /
	sha256.c sha256_Y.c sha256q.c sha256t.c sib.c skein2.c skein.c skunk.c sonoa.c Sponge.c timetravel.c tribus.c veltor.c velvet.c vitalium.c /
	whirlpool.c whirlpoolx.c x11.c x11evo.c x12.c x13.c x14.c x15.c x16r.c x16rt.c x16s.c x17.c x18.c x20r.c x21s.c x22i.c xevan.c yescrypt-opt.c yescrypt.c /
	yespower-opt.c yespower.c zr5.c
	
OBJECTS=$(SOURCES:%.c=%.o) $(SOURCES:%.cpp=%.o) $(SOURCES:%.cc=%.o)
OUTPUT=libalgos.a

all: $(SOURCES) $(OUTPUT)

$(OUTPUT): $(OBJECTS)
	ar rc $@ $(OBJECTS)
	touch ../stratum.cpp

.cpp.o:
	$(CC) $(CXXFLAGS) -c $< -o $@

.c.o:
	$(CC) $(CFLAGS) -c $< -o $@

#	$(CC) $(CFLAGS) -std=gnu99 -Wno-pointer-sign -Wno-pointer-to-int-cast -funroll-loops -fvariable-expansion-in-unroller -fmerge-all-constants -fbranch-target-load-optimize2 -fsched2-use-superblocks -falign-loops=16 -falign-functions=16 -falign-jumps=16 -falign-labels=16 -Ofast -flto -fuse-linker-plugin -ftree-loop-if-convert-stores -DUSE_ASM -pg $<

clean:
	rm -f *.o
	rm -f ar2/*.o
	rm -f blake2/*.o
	rm -f SWIFFTX/*.o
