CC = g++ -Wall -O3 -fPIC -g
LIBFLAGS= -lm
SRC_DIR = ./src/
OBJETOS_DIR = ./obj/
BUILD_DIR = ./build/
#SRCS = main.cpp \
#       global.cpp \
#       problema_1.cpp \
#       problema_2.cpp \
#       problema_3.cpp \
#       problema_4.cpp \
#       problema_5.cpp \
#       problema_6.cpp \
#       problema_7.cpp

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
