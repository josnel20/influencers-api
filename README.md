# Ambiente de Desenvolvimento Laravel com Docker


## Overview
Esta API será utilizada, inicialmente para cadastro de influencer sua listagem atreladas com suas campanhas de marketink:
- Influenciadores 
- Campanhas

## Instruções para subir os containers

### Desenvolvimento local

### Pré-requisitos

- Docker instalado.
[Documentação](https://docs.docker.com/)


Clone o projeto do Repositório Github:

```bash
git clone https://github.com/josnel20/influencers-api.git
cd influencers-api.git
```

Configuração do Banco de Dados
---

Crie o arquivo .env com o comando abaixo:

```sh
cp .env.example .env
```

Dados de conexão com Banco de Dados dentro do arquivo .env

```sh
DB_CONNECTION='normalmente é o nome do SGBD'
DB_HOST='Nome do serviço | Nome do container | IP do container '
DB_PORT='porta padrão utilizada pelo SGBD mas pode ser qualquer uma desde que não esteja sendo utilizada por outro serviço'
DB_DATABASE='nome da base'
DB_USERNAME='usuario do banco'
DB_PASSWORD='senha do banco'
```

Executando o projeto na primeira vez (build)
---

Na raiz do projeto é possível observar o arquivos **docker-compose.yml**:
1. docker-compose-dev.yml (ambiente local)

Obs.: Não commitar alterações desse arquivo.

Para rodar o projeto em ambiente de desenvolvimento, execute o comando abaixo.


```sh
./vendor/bin/sail up -d ou
```

Autenticação simples com JWT
---
você precisa gerar uma chave secreta para assinar seus tokens JWT. Execute o seguinte comando:
```sh
php artisan jwt:secret
```
Isso gerará uma chave no arquivo .env, algo como: JWT_SECRET=sua-chave-secret
