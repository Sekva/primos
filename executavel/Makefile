CC = g++ -static -Wall -O3 -fPIC -g
LIBFLAGS= -lm -lgmpxx -lgmp
SRC_DIR = ./src/
OBJETOS_DIR = ./obj/
BUILD_DIR = ./build/

SRCS := $(shell ls src/*.cpp | cut -d '/' -f2)

BIN_NOME = libtqp.so
OBJS = $(SRCS:.cpp=.o)
OBJS_FINAL = $(OBJS:%.o=$(OBJETOS_DIR)%.o)
	BIN = $(BUILD_DIR)$(BIN_NOME)

all : $(BIN)

$(BIN) : $(OBJS_FINAL)
	$(CC) -shared $(OBJS_FINAL) -o $(BIN) $(LIBFLAGS)

$(OBJS_FINAL) : $(OBJETOS_DIR)%.o : $(SRC_DIR)%.cpp
	$(CC) -c $< -o $@

clean :
	rm  $(BIN) $(OBJS_FINAL)
