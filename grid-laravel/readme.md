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
