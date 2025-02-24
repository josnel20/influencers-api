# Influencers API - Ambiente de Desenvolvimento Laravel com Docker

## Visão Geral
Esta API gerencia influenciadores e campanhas de marketing, permitindo:
- Cadastro e listagem de influenciadores
- Cadastro e listagem de campanhas
- Relacionamento entre influenciadores e campanhas
- Autenticação simples via JWT

## Requisitos
- **Docker** e **Docker Compose** instalados
  - [Documentação Docker](https://docs.docker.com/)
- **Git** instalado
  - [Documentação Git](https://git-scm.com/)

## Instalação e Configuração

### 1. Clonar o Repositório
```bash
git clone https://github.com/josnel20/influencers-api.git
cd influencers-api
```

### 2. Configurar o Ambiente
Crie o arquivo `.env` baseado no `.env.example`:
```sh
cp .env.example .env
```
Atualize os dados de conexão com o banco de dados no `.env`:
```plaintext
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

### 3. Subir os Containers Docker
Execute o comando para iniciar os containers:
```bash
./vendor/bin/sail up -d
```
Isso iniciará:
- Um contêiner com o Laravel (PHP + Apache)
- Um contêiner com MySQL

### 4. Instalar Dependências e Configurar o Banco de Dados
Entre no contêiner do Laravel:
```bash
./vendor/bin/sail exec laravel.test bash
```
Dentro do contêiner, instale as dependências:
```bash
composer install
```
Gere a chave da aplicação:
```bash
php artisan key:generate
```
Execute as migrações e populamento inicial:
```bash
php artisan migrate --seed
```
Gere a chave secreta do JWT:
```bash
php artisan jwt:secret
```
Saia do contêiner:
```bash
exit
```

### 5. Testar a API
Acesse a API via:
```
http://localhost
```

## Endpoints da API

### Autenticação
- **POST /api/v1/cadastrar** - Registrar um usuário
- **POST /api/v1/login** - Fazer login e obter um token JWT

### Influenciadores
- **GET /api/v1/sistema/influencer** - Listar influenciadores
- **POST /api/v1/sistema/influencer/criar** - Criar influenciador

### Campanhas
- **GET /api/v1/sistema/campanhas** - Listar campanhas
- **POST /api/v1/sistema/campanhas** - Criar campanha

### Relacionamento Influenciador-Campanha
- **POST /api/v1/sistema/campanhas/vincular-influenciadores/{id_campanha}** - Relacionar influenciador a uma campanha

## Documentação dos Endpoints
A documentação completa pode ser acessada no Swagger/Postman, presentes no diretório raiz do projeto:
- **swagger.yml**
- **Influencers-app.postman_collection.json**

## Testes
Para rodar os testes unitários:
```bash
./vendor/bin/sail artisan test
```

## Considerações Finais
- O projeto utiliza **Laravel 11+** e **JWT** para autenticação.
- Docker e Docker Compose facilitam a configuração do ambiente.
- Utilize **Postman** ou **Insomnia** para testar os endpoints manualmente importando o arquivo **Influencers-app.postman_collection.json**.

**Autor:** Jose Pison  
**Email:** Pisonj30@gmail.com

