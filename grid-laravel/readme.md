## Projeto do Banco de Dados - Grid
---

**Problema - Problemas**
- id: int
- prioridade: short int
- nome string
- descricao: json
- links: json


**Trabalho - Trabalhos**
- id: unsigned bigint
- status: short int
- id_problema: int
- conteudo: json

**Resposta - Respostas**
- id: unsigned bigint
- id_problema: int
- id_trabalho: int
- conteudo: json


### Para criar o usuário e banco de dados no mysql:
```bash
$ mysql
```
Se o comando de cima barrar por conta de privilégio:
```bash
$ mysql -u root -p
```
```sql
CREATE DATABASE pesquisa;
CREATE USER 'pesquisa'@'localhost' IDENTIFIED BY 'pesquisa';
GRANT ALL PRIVILEGES ON pesquisa.* TO 'pesquisa'@'localhost';
FLUSH PRIVILEGES;
quit
```

Para ver os usuários do banco e os bancos criados:
```sql
SELECT user FROM mysql.user;
SHOW DATABASES;
```

Lembrar de descomentar a linha a seguir em 'php.ini'.
```ini
extension=pdo_mysql
```
