CC = g++ -static -Wall -s -O3
LIBFLAGS= -lm
SRC_DIR = ./src/
OBJETOS_DIR = ./obj/
BUILD_DIR = ./build/
SRCS = main.cpp \
	global.cpp \
	problema_1.cpp \
	problema_2.cpp \
	problema_3.cpp \
	problema_4.cpp \
	problema_5.cpp \
	problema_6.cpp \
	problema_7.cpp

BIN_NOME = tqp_win
OBJS = $(SRCS:.cpp=.o)
OBJS_FINAL = $(OBJS:%.o=$(OBJETOS_DIR)%.o)
BIN = $(BUILD_DIR)$(BIN_NOME)

all : $(BIN)

$(BIN) : $(OBJS_FINAL)
	$(CC) $(OBJS_FINAL) -o $(BIN) $(LIBFLAGS)

$(OBJS_FINAL) : $(OBJETOS_DIR)%.o : $(SRC_DIR)%.cpp
	$(CC) -c $< -o $@

clean :
	rm  $(BIN) $(OBJS_FINAL)
