# TJ BOOKS API

TJ BOOKS API é um microsserviço criado para ser acessado via api, a fim de cuidar de toda a regra de negócio de um cadastro de livros.
Suas funcionalidades envolvem: 
- CRUD de Autores, Assuntos e Livros, incorporando regras de negócio específicas.
- Relatórios: o principal agrupado por autor e dados para uso de dashboards.
- TDD (em construção testes para as persistências)

## Requisitos
- [LARAGON](https://laragon.org/). Servidor virtual para rodar PHP, Apache, Nginx, Node.
- [Postgres](https://www.postgresql.org/download/)
- [DataGrip](https://www.jetbrains.com/datagrip/features/postgresql/) (Opcional: gerenciador para Postgres)

## Instalação

1. Clone o repositório em sua máquina:

   ```bash
   git clone git@github.com:marinapelosi/tj-books-api.git

2. Acesse o diretório:

   ```bash
   cd tj-books-api

3. Mantenha a branch main:

   ```bash
   git checkout main

4. Associe o arquivo de configuração:

   ```bash
   cp .env.example .env

5. Em seu administrador do Postgres, crie o banco de dados e coloque os dados no `.env`, como no exemplo a seguir:

```
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=tj-books
    DB_USERNAME=postgres
    DB_PASSWORD=123456
```
   
6. Instale todas as dependências:

   ```bash
   composer install

7. Execute as migrations para criação das tabelas e views no banco de dados:

   ```bash
   php artisan migrate --seed

8. Levante o ambiente de desenvolvimento (por padrão do Laravel a URL da api é http://locahost:8000):

   ```bash
   php artisan serve


## Comandos úteis

### Limpar o banco de dados do zero
    ```bash
       php artisan migrate:fresh --seed
  
### Limpar o cache do Laravel
    ```bash
       php artisan optimize:clear

### Limpar o cache nas depedências
    ```bash
       composer dump-autoload

### Executar TDD
    ```bash
       php artisan test


