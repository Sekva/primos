# GRID - Processamento em Larga Escala
#### Pequena documentação para instalação do grid. É exigido algum domínio de comandos do linux e conhecimento prévio de algumas tecnologias, como servidor apache, php, banco de dados, etc.

---

## 🚀 Começando

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local para fins de desenvolvimento e teste.

### 📋 Pré-requisitos

Para rodar o site será necessário ter:

```bash
Apache2 (Ou algum servidor compatível com php)
PHP (versao 7.0 - 7.3)
MariaDB (Ou qualquer outro banco de dados)
```

### 🔧 Instalação do Servidor

A partir daqui, haverão comandos úteis para a instalação dos pré-requisitos acima mencionados, afim de ter um ambiente de desenvolvimento em execução.

**Antes de tudo, como todo bom desenvolvedor, começaremos com o passo _zero_, que será download do projeto**

**A primeira etapa é instalar o PHP, Apache2 e o MariaDB, veja que será necessário a utilização da versão >= 7.0:**

> O Apache2 aqui poderá ser substituído pelo uso do servidor web integrado no próprio php. Isso será discutido na terceira etapa.

- Baixe e instale o PHP Apache2 e MariaDB

```bash
sudo apt-get install apache2 php7.0 php7.0-mysql libapache2-mod-php mariadb-client mariadb-server
```
> Para partir para a próxima etapa, a etapa um é pré requisito.

**A segunda etapa é a construção e configuração do banco de dados:**

- Para isso, é necessário estar com super usuário;

```bash
mysql -u root -p
```
- Substitua 'nome' por o nome do seu banco de dados.

```bash
MariaDB [(none)]> CREATE DATABASE nomeExemplo_db;
MariaDB [(none)]> CREATE USER 'nomeExemplo_user'@'localhost' IDENTIFIED BY 'nomeExemplo_pass';
MariaDB [(none)]> GRANT ALL PRIVILEGES ON nomeExemplo_db.* TO 'nomeExemplo_user'@'localhost';
MariaDB [(none)]> FLUSH PRIVILEGES;
MariaDB [(none)]> quit
```

- Após isso, faça uma cópia do arquivo '.env.example' com o nome '.env' para a **pasta do projeto.**

Colocando as suas respectivas informações, como mostrado no exemplo ('.env.example')

> Nota: O arquivo .env ficará dentro da pasta dos projeto. Ou seja, cada projeto terá seu próprio .env, possibilitando assim o uso de vários bancos de dados.

> Para partir para a próxima etapa, a etapa um é pré requisito.

**A terceira etapa é a configuração/ativação do servidor web:**

Aqui, exitem duas formas de fazer isso.
- A primeira, é utilizando o apache; Para isso é necessário fazer um link do repositório do servidor do grid em /var/www/
```bash
cd /var/www/
sudo ln -s <Diretorio da pasta do servidor> ./grid/
```
Após isso, é preciso configurar o apache para redirecionar para essa pasta, ao invés da /var/www/html. Para isso, mude o 'DocumentRoot' do arquivo:
/etc/apache2/sites-available/000-default.conf, ficando da seguinte forma:

    -> DocumentRoot /var/www/html/grid

- A segunda forma de fazer isso, é simplesmente utilizar o servidor web do próprio php. Após instalado o php, indo até o diretório do servidor, basta executar o seguinte comando:
```bash
php -S localhost:8000
```

   > Nota: Para acessar o servidor, basta ir até http://localhost:8000

> Nota: Recomenda-se fortemente a utilização do servidor web apache2. Pois testes foram feitos e houveram comportamentos indevidos quanto as rotas dos links e outras coisas. Além de ele suportar erros que o simples servidor php não suporta e fecha.

> Para partir para a próxima etapa, a etapa dois é pré requisito.

**A quarta etapa é construção da base de dados (trabalhos e user):**

Para isso, é necessário um conhecimento mínimo de Banco de Dados, para que seja possível realizar a criação de tabelas.

Contudo, é possível fazer uso de programas como o DBeaver ou PhpMyAdmin, para facilitar o processo.


Partindo daí, para os projetos de exemplo que compõem o pacote (ExemploA e ExemploB), deve-se criar para ambos as seguintes tabelas, com as seguintes estruturas:

###### _Para o projeto ExemploA:_
- Nome do banco: sdDataBase
- Nome da tabela: exemploA
    - id (int, not null, primary key, auto increment)
    - iteracao (int, not null, default: 10000)
    - processando (int, not null)
    - vezesProcessado (int, not null)
    - limite (int, not null)
    - valorAtual (int, not null)
    - ultimaVezProcessado (int, not null)
    - ultimaVezRequisitado (int, not null)

###### _Para o projeto ExemploB:_
O mesmo deve ser feito para a tabela do projeto ExemploB, no mesmo banco de dados (não restrito a isso), mas com o nome da tabela sendo: exemploB

###### _Para os Usuários:_
Ainda na mesma base de dados (mas não restrito a isso), deve-se realizar a criação da tabela de usuários. Tendo a seguinte estrutura:

- Nome da tabela: users
    - id (int, not null, primary key, auto increment)
    - nome (str, not null)
    - pontos (int, not null, default: 0)
    - timeUltimoProcessamento (str, not null, default: 0)

> Partindo daí, veja como está configurado o arquivo .env, para cada projeto


Ao realizar a construção das tabelas do banco de dados, é preciso povoálas, com isso, nos pŕoprios projetos de exemplo, existe a parte para povoamento das mesmas. Onde também pode-se fazer isso de forma automática utilizando o _curl_, direto pelo terminal linux (para os mais experientes).

> Para partir para a próxima etapa, todas as etapas anteriores são pré requisito.


**A quinta etapa é referente à execução do projeto:**

Com o servidor instalado, observemos agora quanto a questão do cliente;
Para isso, iremos realizar a instalação do Python3:

```bash
sudo apt install python3-dev
```

Feito isso, para execução do script cliente, deve-se primeiramente observar o resultado de sua execução com o parâmetro -h.

```bash
python3 cliente.py -h
```

Com isso, pode-se executar o script com o novo endereço do servidor, definindo parâmetros para execução:

```bash
python3 cliente.py -host http://localhost/ -t 3 -n 50
```

**=D**


## 📌 Versão

Nós usamos [SemVer](http://semver.org/) para controle de versão.

## 🛠️ Ferramentas utilizadas

As ferramentas que usamos para criar o projeto:

* DBeaver - Cliente SQL
* MariaDB - SGDB

## ✒️ Autores

* [**Mateus Baltazar**](https://github.com/MBaltz);
* [**Matheus Machado**](https://github.com/Sekva);

## 📄 Licença

Este projeto está sob a licença **MIT License**.
