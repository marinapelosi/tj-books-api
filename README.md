# TJ BOOKS API

Para acessar a documentação do Front, [clique aqui]().

## Sumário
- Introdução
- Requisitos
- Instalação + Comandos Úteis
- Utilização da API
- Documentação técnica (**Muito Importante**)
  - Por que back-end em Laravel?
  - Por que banco de dados PostgresSQL?
  - Melhorias de performance no banco de dados
  - Utilização de DTO para manter integridade dos campos no modelo de dados
  - Tabelas nativas do Laravel e Laravel Passport OAuth2
  - Relacionamentos entre tabelas via Eloquent
  - Criação de View no BD para relatório
  - Diagramas (CRUD)
    - Fluxo ponta a ponta de `read`, com tratamento de dados para mascarar campos do banco de dados
    - Fluxo ponta a ponta de `create/update`, com pré-validações
    - !!!!!! VERIFICAR SE DÁ TEMPOREGRAS DE NEGÓCIO (VALIDAÇÕES)
    - Servicessssss
  - TDD
  - Sugestão de melhorias
  - Considerações finais


-------

## Introdução 
 
TJ BOOKS API é um microsserviço criado para ser acessado via api, a fim de cuidar de toda a regra de negócio de um cadastro de livros.
Suas funcionalidades envolvem:

- CRUD de Autores, Assuntos e Livros, incorporando regras de negócio específicas.
- Relatórios: o principal agrupado por autor e dados para uso de dashboards.
- TDD

-------

## Requisitos
- [LARAGON](https://laragon.org/). Servidor virtual para rodar PHP, Apache, Nginx, Node.
- [PostgresSQL](https://www.postgresql.org/download/)
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

5. Em seu administrador do PostgresSQL, crie o banco de dados e coloque os dados no `.env`, como no exemplo a seguir:

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

### Comandos úteis

#### Limpar o banco de dados do zero
    
    php artisan migrate:fresh --seed
  
#### Limpar o cache do Laravel

    php artisan optimize:clear

#### Limpar o cache nas depedências

    composer dump-autoload

#### Executar TDD

    php artisan test

-------

## Utilização da API

### Rotas

| Tipo   | Rota                                           | Descrição                                            |
|--------|------------------------------------------------|------------------------------------------------------|
| POST   | `/api/login`                                   | Autenticação de usuário via Passport OAuth2 (futuro) |
| GET    | `/api/books`                                   | Lista todos os livros                                |
| POST   | `/api/books/filter`                            | Filtra livros com base em parâmetros                 |
| GET    | `/api/books/{id}`                              | Obtém detalhes de um livro específico por Codl       |
| POST   | `/api/books`                                   | Adiciona um novo livro                               |
| PUT    | `/api/books/{id}`                              | Atualiza informações de um livro por Codl            |
| DELETE | `/api/books/{id}`                              | Exclui um livro específico por Codl                  |
| GET    | `/api/authors`                                 | Lista todos os autores                               |
| POST   | `/api/authors/filter`                          | Filtra autores com base em parâmetros                |
| GET    | `/api/authors/{id}`                            | Obtém detalhes de um autor específico por CodAu      |
| POST   | `/api/authors`                                 | Adiciona um novo autor                               |
| PUT    | `/api/authors/{id}`                            | Atualiza informações de um autor por CodAu           |
| DELETE | `/api/authors/{id}`                            | Exclui um autor específico por CodAu                 |
| GET    | `/api/subjects`                                | Lista todos os assuntos                              |
| POST   | `/api/subjects/filter`                         | Filtra assuntos com base em parâmetros               |
| GET    | `/api/subjects/{id}`                           | Obtém detalhes de um assunto específico por CodAs    |
| POST   | `/api/subjects`                                | Adiciona um novo assunto                             |
| PUT    | `/api/subjects/{id}`                           | Atualiza informações de um assunto por CodAs         |
| DELETE | `/api/subjects/{id}`                           | Exclui um assunto específico por CodAs               |
| GET    | `/api/reports/dashboard`                       | Gera relatório de dashboard                          |
| GET    | `/api/reports/dashboard-counters`              | Gera relatório de contadores do dashboard            |
| GET    | `/api/reports/dashboard-topfives`              | Gera relatório dos top cinco do dashboard            |
| GET    | `/api/reports/dashboard-lastbooks`             | Gera relatório dos últimos livros do dashboard       |
| GET    | `/api/reports/book-by-author-grouping-authors` | Gera relatório de livros agrupados por autor         |

### Rotas com parâmetros (Obs.: as rotas filters não estão inclusas na doc porque não estão sendo usadas no app no momento, mas podemos falar delas na apresentação)

#### POST `/api/login`


| Parâmetro | Tipagem | Validação                             | Descrição        | Liberada na branch main   |
|-----------|---------|---------------------------------------|------------------|---------------------------|
| email     | Email   | Obrigatório, Email existente em users | Email de usuário | Não (em progresso)        |
| password  | String  | Obrigatório, Min: 6                   | Senha de usuário | Não (em progresso)        |

*Request Payload*

``` 
{
    "email": "admin@tj.org",
    "password": "admin@2023"
}
```

*Response (Em construção)*

```
{
    "success": true,
    "message": "auth.client_login_success",
    "data": {
        "user": {
            "name": "Administrador",
            "email": "admin@tj.org"
        },
        "token": "5855a24eb52881f7e3f18772e3760ebcba28839a2bc52e5f3f43009434dee642"
    }
}
```



#### POST `/api/authors` || PUT `/api/authors/{id}`


| Parâmetro | Tipagem | Validação          | Descrição     | Liberada na branch main |
|-----------|---------|--------------------|---------------|-------------------------|
| name      | String  | Obrigatório, Único | Nome do autor | Sim                     |

*Request Payload*

``` 
{
    "name": "C.S. Lewis"
}
```

*POST Response*

```
{
    "success": true,
    "message": "Autor criado com sucesso",
    "data": {
        "id": "01hj92mjh4gvk2zch46pph1eb6",
        "name": "Jane Austen"
    }
}
```

*PUT Response*

```
{
    "success": true,
    "message": "Autor atualizado com sucesso",
    "data": {
        "id": "01hj91ktkzqdw48ecgfx8df9rq",
        "name": "Augusto Cury"
    }
}
```

*PUT/POST Validation Response Example*

```
{
    "message": "O campo Nome é obrigatório.",
    "errors": {
        "name": [
            "O campo Nome é obrigatório."
        ]
    }
}
```


#### POST `/api/subjects` || PUT `/api/subjects/{id}`


| Parâmetro   | Tipagem | Validação          | Descrição     | Liberada na branch main |
|-------------|---------|--------------------|---------------|-------------------------|
| description | String  | Obrigatório, Único | Nome do autor | Sim                     |

*Request Payload*

``` 
{
    "description": "Ficção Científica"
}
```

*POST Response*

```
{
    "success": true,
    "message": "Assunto criado com sucesso",
    "data": {
        "id": "01hj95s0wxzptscdv4zh2nn636",
        "description": "Ficção Científica"
    }
}
```

*PUT Response*

```
{
    "success": true,
    "message": "Assunto atualizado com sucesso",
    "data": {
        "id": "01hj95exm36mwntpat0xdesk07",
        "description": "Melhoria Pessoal"
    }
}
```

*PUT/POST Validation Response Example*

```
{
    "message": "Já existe registro com esta descrição.",
    "errors": {
        "description": [
            "Já existe registro com esta descrição."
        ]
    }
}
```


#### POST `/api/books` || PUT `/api/books/{id}`


| Parâmetro       | Tipagem | Validação                                          | Descrição         | Liberada na branch main |
|-----------------|---------|----------------------------------------------------|-------------------|-------------------------|
| title           | String  | Obrigatório, Max:40                                | Título do Livro   | Sim                     |
| publisher       | String  | Obrigatório, Max:40                                | Editora           | Sim                     |
| edition         | Integer | Obrigatório, Max:40                                | Edição            | Sim                     |
| publicationYear | Integer | Obrigatório, Max:(ano atual)                       | Ano de Publicação | Sim                     |
| price           | Decimal | Obrigatório, Moeda (pode ser com ponto ou vírgula) | Preço             | Sim                     |
| authors         | Array   | Obrigatório, Array com um ou mais autores->CodAu   | Autores (mín 1)   | Sim                     |
| subjects        | Array   | Obrigatório, Array com um ou mais assuntos->CodAs  | Assuntos (mín 1)  | Sim                     |

*Request Payload*

``` 
{
    "title": "Teste de edição",
    "publisher": "Sextante",
    "edition": "1",
    "publicationYear": "2023",
    "price": "20,00",
    "authors": ["01hjczdpt8r9s3pqgnkw7tj2r0"],
    "subjects": ["01hjc4f5z4br8ygcbke6a1zvpa"]
}
```

*POST Response*

```
{
    "success": true,
    "message": "Livro criado com sucesso",
    "data": {
        "id": "01hjenpc3jmxsw1tk110qe1yh5",
        "title": "Razão e sensibilidade",
        "publisher": "Martin Claret",
        "edition": 1,
        "publicationYear": 2018,
        "price": "70,14",
        "created_at": "24/12/2023",
        "updated_at": "24/12/2023",
        "authors": [
            {
                "id": "01hjc433kafekgbwnkq41jnwhb",
                "name": "Jane Austen",
                "books_quantity": 4,
                "books": [
                    {
                        "id": "01hjc4gvevb3xx55t195g5142z",
                        "title": "Orgulho e Preconceito",
                        "publisher": "Martin Claret",
                        "edition": 1,
                        "year_publication": 2012,
                        "price": "74,90",
                        "created_at": "23/12/2023",
                        "updated_at": "23/12/2023",
                        "subjects": [
                            {
                                "id": "01hjc4g95xsqtfnbykyakmw7a9",
                                "description": "Ficção",
                                "books_quantity": 8
                            }
                        ]
                    },
                    {
                        "id": "01hjcwj85ffvsz9abqc4dtfmpd",
                        "title": "Razão e sensibilidade",
                        "publisher": "Martin Claret",
                        "edition": 1,
                        "year_publication": 2018,
                        "price": "70,14",
                        "created_at": "24/12/2023",
                        "updated_at": "24/12/2023",
                        "subjects": [
                            {
                                "id": "01hjc4g95xsqtfnbykyakmw7a9",
                                "description": "Ficção",
                                "books_quantity": 8
                            }
                        ]
                    },
                    {
                        "id": "01hjdwamykdpv85e7pwhn8ct2e",
                        "title": "Teste com 4 assuntos e 3 autores",
                        "publisher": "Sextante",
                        "edition": 20,
                        "year_publication": 2023,
                        "price": "100,00",
                        "created_at": "24/12/2023",
                        "updated_at": "24/12/2023",
                        "subjects": [
                            {
                                "id": "01hjc4f5z4br8ygcbke6a1zvpa",
                                "description": "Autoconhecimento",
                                "books_quantity": 2
                            },
                            {
                                "id": "01hjc4g95xsqtfnbykyakmw7a9",
                                "description": "Ficção",
                                "books_quantity": 8
                            },
                            {
                                "id": "01hjd4f2s0njds6ygfg26enavr",
                                "description": "Melhoria pessoal",
                                "books_quantity": 2
                            },
                            {
                                "id": "01hjd6zfnzw0brxdw40tqth5sx",
                                "description": "Crítica Implícita",
                                "books_quantity": 1
                            }
                        ]
                    },
                    {
                        "id": "01hjenpc3jmxsw1tk110qe1yh5",
                        "title": "Razão e sensibilidade",
                        "publisher": "Martin Claret",
                        "edition": 1,
                        "year_publication": 2018,
                        "price": "70,14",
                        "created_at": "24/12/2023",
                        "updated_at": "24/12/2023",
                        "subjects": [
                            {
                                "id": "01hjc4g95xsqtfnbykyakmw7a9",
                                "description": "Ficção",
                                "books_quantity": 8
                            }
                        ]
                    }
                ]
            }
        ],
        "authors_quantity": 1,
        "subjects": [
            {
                "id": "01hjc4g95xsqtfnbykyakmw7a9",
                "description": "Ficção",
                "books_quantity": 8
            }
        ],
        "subjects_quantity": 1
    }
}
```

*PUT Response*

```
{
    "success": true,
    "message": "Livro atualizado com sucesso",
    "data": {
        "id": "01hjenpc3jmxsw1tk110qe1yh5",
        "title": "Teste de edição",
        "publisher": "Sextante",
        "edition": 1,
        "publicationYear": 2023,
        "price": "20,00",
        "created_at": "24/12/2023",
        "updated_at": "24/12/2023",
        "authors": [
            {
                "id": "01hjczdpt8r9s3pqgnkw7tj2r0",
                "name": "Augusto Cury",
                "books_quantity": 2,
                "books": [
                    {
                        "id": "01hjdwamykdpv85e7pwhn8ct2e",
                        "title": "Teste com 4 assuntos e 3 autores",
                        "publisher": "Sextante",
                        "edition": 20,
                        "year_publication": 2023,
                        "price": "100,00",
                        "created_at": "24/12/2023",
                        "updated_at": "24/12/2023",
                        "subjects": [
                            {
                                "id": "01hjc4f5z4br8ygcbke6a1zvpa",
                                "description": "Autoconhecimento",
                                "books_quantity": 3
                            },
                            {
                                "id": "01hjc4g95xsqtfnbykyakmw7a9",
                                "description": "Ficção",
                                "books_quantity": 7
                            },
                            {
                                "id": "01hjd4f2s0njds6ygfg26enavr",
                                "description": "Melhoria pessoal",
                                "books_quantity": 2
                            },
                            {
                                "id": "01hjd6zfnzw0brxdw40tqth5sx",
                                "description": "Crítica Implícita",
                                "books_quantity": 1
                            }
                        ]
                    },
                    {
                        "id": "01hjenpc3jmxsw1tk110qe1yh5",
                        "title": "Teste de edição",
                        "publisher": "Sextante",
                        "edition": 1,
                        "year_publication": 2023,
                        "price": "20,00",
                        "created_at": "24/12/2023",
                        "updated_at": "24/12/2023",
                        "subjects": [
                            {
                                "id": "01hjc4f5z4br8ygcbke6a1zvpa",
                                "description": "Autoconhecimento",
                                "books_quantity": 3
                            }
                        ]
                    }
                ]
            }
        ],
        "authors_quantity": 1,
        "subjects": [
            {
                "id": "01hjc4f5z4br8ygcbke6a1zvpa",
                "description": "Autoconhecimento",
                "books_quantity": 3
            }
        ],
        "subjects_quantity": 1
    }
}
```

*PUT/POST Validation Response Example*

```
{
    "message": "O campo Título é obrigatório. (and 5 more errors)",
    "errors": {
        "title": [
            "O campo Título é obrigatório."
        ],
        "edition": [
            "A Edição deve ser um dado numérico"
        ],
        "publicationYear": [
            "Ano de Publicação é um campo numérico",
            "Insira um Ano de Publicação válido."
        ],
        "price": [
            "O campo Preço deve ser em reais"
        ],
        "authors": [
            "Você deve informar uma lista contendo um ou mais autores deste livro."
        ]
    }
}
```

--------

## Documentação técnica

### Por que back-end em Laravel?
O Laravel foi escolhido como backend porque ele auxilia na criação de api seguras, organizadas e em boas práticas de clean code. 

### Por que banco de dados PostgresSQL?
O PostgresSQL foi escolhido devido ao seu suporte robusto a transações, escalabilidade e desempenho. A escolha também foi feita fizando sua capacidade de extensão para necessidades específicas, como o PostGIS, por exemplo, caso fosse necessário acoplar um sistema de cálculo de entrega para os livros.

### Melhorias de performance no banco de dados
Conforme solicitado, a integridade do banco de dados foi mantida, os nomes dos campos foram mantidos. Entretanto, como autorizado, algumas mudanças foram feitas para fins de melhoria de desempenho. 

> Exceto, pelo nomes das tabelas que foram padronizados no plural, para melhoria semântica e evitar ambiguidades ou falta de entedimento em caso de expansão do banco de dados.

A seguir, serão citadas as melhorias de desempenho e seus respectivos motivos:

- ULID como Chave Primária para livros, autores, e Tabelas de Relacionamento.

> Motivo: A utilização de ULID (Universally Unique Lexicographically Sortable Identifier) como chave primária é melhor que integer autoincrement porque oferece unicidade global e, com isso, reduz a probabilidade de colisões mesmo em ambientes distribuídos. É também muito mais seguro não exibir um id como inteiro.

- Índice nas seguintes `table->coluna`: `livros->Titulo`, `autores->Nome`, `assuntos->Descricao` 

> Motivo: Foi adicionado um índice à cada coluna descritiva principal, dessas tabelas, para otimizar futuras consultas de busca e ordenação baseadas na coluna, melhorando a eficiência de operações de leitura.
> Para Chaves Primárias: A forma de criação foi fazendo a chamada ->index() nas migrations para que o Laravel crie índices para os campos.
> Para Chaves Estrangeiras: Nas migrations, ao declarar a coluna, foi adicionada a chamada ->constrained() para que o Laravel adicione a chave estrangeira, mas também crie o índice específico e assim, tenhamos o desempenho melhorado.

### Utilização de DTO para manter integridade dos campos no modelo de dados

Não se assuste ao ver os campos tratados em inglês nos métodos de cadastro e edição. Isso foi feito para que o real nome dos campos (em Português e CamelCase) sejam mascarados e protegidos das vistas do front/client.

Para isso, foram criadas manualmente DTOs (Data Transfer Object), que seguem um Design Pattern utilizado normalmente para transferir dados entre várias partes da aplicação, usando encapsulamento. O intuito aqui não é utilizar uma camada de persistência desacoplada, apesar de DTO proporcionar isso, mas adicionar uma camada de segurança e também unificação ao efetuar as persistências de cadastro e atualização de dados.

### Tabelas nativas do Laravel e Laravel Passport OAuth2

O Laravel usa tabelas nativas para uso do framework, como `migrations: que auxilia a criar tabelas no banco de dados via programação` e `jobs: para controlar os jobs em caso de uso de queue`.

> Importante ressaltar que, na tentativa de instalar o `Laravel Passport`, para efetuar login via OAuth2, que ainda está em construção, o componente instala tabelas iniciando com `oauth_`.


### Relacionamentos entre tabelas via Eloquent ORM

O Eloquent ORM desmistifica o uso de JOINS para facilitar a performance do framework juntamente com o banco de dados, eliminando a necessidade de criar vários joins na aplicação. 

Em cada `Model/` é possível verificar a camada de relation. Por exemplo:

- `Author:books`: `autores` está relacionada com `livros`, por intermédio de `livros_autores`. 

> E a relação é N pra N (No Eloquent BelongsToMany), pois um autor pode escrever vários livros e um livro pode ter vários autores associados a ele.
```
public function books(): BelongsToMany
{
    return $this->belongsToMany(Book::class, 'livros_autores', 'Autor_CodAu', 'Livro_Codl');
}
```

- `Subject:books`: `assuntos` está relacionada com `livros`, por intermédio de `livros_assuntos`.

> E a relação é N pra N (No Eloquent BelongsToMany em Subject), pois um assunto pode estar associado em vários livros e um livro pode ter vários assuntos associados a ele.
```
public function books(): BelongsToMany
{
    return $this->belongsToMany(Book::class, 'livros_assuntos', 'Assunto_CodAs', 'Livro_Codl');
}
```

- `Books:authors`: `livros` pode pertencer a vários `autores`, por intermédio de `livros_autores`.
- `Books:subjects`: `livros` pode pertencer a vários `assuntos`, por intermédio de `livros_assuntos`.

```
public function authors(): BelongsToMany
{
    return $this->belongsToMany(Author::class, 'livros_autores', 'Livro_Codl', 'Autor_CodAu');
}

public function subjects(): BelongsToMany
{
    return $this->belongsToMany(Subject::class, 'livros_assuntos', 'Livro_Codl', 'Assunto_CodAs');
}
```

### Criação de View no BD para relatório

Devido Eloquent ORM, como explicado acima, o único local que utiliza JOIN diretamente é na migration que cria a View no Banco de Dados para gerar o relatório solicidado.

A criação da view, encontra-se no arquivo: `database/2023_12_24_143730_create_report_books_by_author_grouping_by_authors_view`

Outras views foram criadas, mas só esta está sendo usada por estar alinhada ao padrão solicitado na proposta.


--------

## Diagramas (CRUD)

### Fluxo ponta a ponta de `read`, com tratamento de dados para mascarar campos do banco de dados

![get-fluxo-api-gets.png](doc-imgs%2Fget-fluxo-api-gets.png)

> Legenda
>
> 1) O request para api é feito via rotas GET,de listagem ou busca por id, seja pelo front ou postman.
> 2) O Controller é acionado diretamente e acessa uma biblioteca (FilterLib) interna criada exclusivamente para auxiliar nos futuros filtros para este projeto. Quando não há parâmetro de filtro, que é o nosso caso, ela faz o `get` usando as parametrizações passadas para ordenação, eloquent relations, dentre outras.
> 3) A FilterLib de cada entidade é responsável por acessar a camada de persistência Model e adicionar os parâmetros necessários para busca, seja com filtros ou não.
> 4) A Model solicita ao banco de dados as informações solicitadas e retorna para FilterLib os dados crus, ou seja, com os campos íntegros no banco de dados, e com os relacionamentos solicitatos pelo eloquent ORM.
> 5) Com os dados, um Resource é acionado para a entidade e este é um recurso do Laravel para que se possa personalizar o retorno dos dados. É semelhante ao DTO, mas é exclusivamente para retornar os `campo/valor` a serem utilizados pelo front, então aqui é possível mascarar os reais nomes dos campos no banco de dados. Proporcionando sanitização também na saída de dados.
> 6) Com o resource executado, a resposta da API é retornada.


### Fluxo ponta a ponta de `create/update`, com pré-validações

![post-put-fluxo-end-to-end.png](doc-imgs%2Fpost-put-fluxo-end-to-end.png)

> Legenda
> 
> 1) O request para api é feito via rotas POST/PUT, seja pelo front ou postman.
> 2) O Form Request é um recurso do Laravel que permite fazer a validação antes mesmo de iniciar o Controller, para preservar o desempenho. Ao passar pelo Form Request, é utilizado um Validator que possui validações por parametrização e evita a escrita de diversos ifs para verificar o que está vindo e já faz uma validação direta, de acordo com os parâmetros passados.
> 3) Caso exista erro de validação no Form Request, o Controller nem é acionado, pois a api já retorna por padrão os erros no response.
> 4) Caso não exista erro, o Controller é iniciado e pode prosseguir. Por causa do Form Request, não é necessário inserir vários try/catchs ou ifs desnecessários, pois presume-se que ao passar pelo FormRequest, o tratamento de erro já foi feito na pré-validação. Vale lembrar que isso também faz com que os campos sejam sanitizados, para auxiliar na segurança sugerida pela OWASP.
> 5) Seguindo o fluxo, o Controller aciona o DTO para fazer o transporte de dados, ou seja, converter os names dos campos do request para os reais nomes dos campos no banco de dados.
> 6) A partir disto, os dados são passados para a camada de persistência utilizada no padrão MVC do Laravel, que é a Model, aplicando o método necessário `create` ou `update` para efetuar a persistência dos dados.
> 7) A Model retorna o objeto response do banco de dados ao Controller e este segue.
> 8) Em caso de possibilidade de erro, o Controller trata o erro e envia a resposta da API.
> 9) Em caso de não possibilidade de erro, o Controller já envia direto a resposta da API.
 
![get-fluxo-api-gets.png](doc-imgs%2Fget-fluxo-api-gets.png)


-------
## TDD

Alguns testes (Unitários e Feature) foram criados para as classes principais, a fim de garantir a persistência de dados (create, update, delete).

As entidades que possuem teste são: 

### Author
> Unitários: AuthorRequestUnitTest, AuthorControllerUnitTest

Que irão testar o funcionamento dos métodos das persistências de autores e suas validações.

> Feature: AuthorFeatureTest

Que irá testar o funcionamento das persistências por meio dos endpoints.


### Subject
> Unitários: SubjectRequestUnitTest, SubjectControllerUnitTest

Que irão testar o funcionamento dos métodos das persistências de assuntos e suas validações.

> Feature: SubjectFeatureTest

Que irá testar o funcionamento das persistências por meio dos endpoints.

### Book
> Unitários: BookRequestUnitTest, BookControllerUnitTest

Que irão testar o funcionamento dos métodos das persistências de livros e suas validações.

> Feature: BookFeatureTest

Que irá testar o funcionamento das persistências por meio dos endpoints.

![test-1.png](doc-imgs%2Ftest-1.png)
![test-2.png](doc-imgs%2Ftest-2.png)

### Exemplo real de execução e retorno
```
  php artisan test
```

```
   PASS  Tests\Unit\AuthorControllerUnitTest
  ✓ should create author successfully                                                                                                                                     0.28s
  ✓ should update author successfully                                                                                                                                     0.06s
  ✓ should delete author successfully                                                                                                                                     0.06s

   PASS  AuthorRequestUnitTest
  ✓ should pass author validation successfully                                                                                                                            0.17s
  ✓ should not pass author validation                                                                                                                                     0.02s

   PASS  BookControllerUnitTest
  ✓ should create book successfully                                                                                                                                       0.09s
  ✓ should update book successfully                                                                                                                                       0.07s
  ✓ should delete book successfully                                                                                                                                       0.07s

   PASS  BookRequestUnitTest
  ✓ should pass author validation successfully                                                                                                                            0.06s
  ✓ should not pass author validation                                                                                                                                     0.06s

   PASS  SubjectControllerUnitTest
  ✓ should create subject successfully                                                                                                                                    0.08s
  ✓ should update subject successfully                                                                                                                                    0.06s
  ✓ should delete subject successfully                                                                                                                                    0.06s

   PASS  SubjectRequestUnitTest
  ✓ should pass subject validation successfully                                                                                                                           0.06s
  ✓ should not pass subject validation                                                                                                                                    0.02s

   PASS  AuthorFeatureTest
  ✓ should create author successfully                                                                                                                                     0.09s
  ✓ should not create author because form request validation                                                                                                              0.06s
  ✓ should update author successfully                                                                                                                                     0.18s
  ✓ should delete author successfully                                                                                                                                     0.07s
  ✓ should not delete author because it has books                                                                                                                         0.07s

   PASS  BookFeatureTest
  ✓ should create book successfully                                                                                                                                       0.08s
  ✓ should not create book because form request validation                                                                                                                0.07s
  ✓ should update book successfully                                                                                                                                       0.09s
  ✓ should delete book successfully                                                                                                                                       0.18s

   PASS  SubjectFeatureTest
  ✓ should create subject successfully                                                                                                                                    0.19s
  ✓ should not create subject because form request validation                                                                                                             0.17s
  ✓ should update subject successfully                                                                                                                                    0.06s
  ✓ should delete subject successfully                                                                                                                                    0.16s
  ✓ should not delete author because it has books
```

-------
## Sugestão de melhorias para expansão deste projeto no futuro

- Adição de campos para utilização pública, por exemplo, o ISBN do Livro.
- Criação de campos de busca para utilizar as rotas `filter` criadas e assim facilitar o filtro de datable no front.
- Com isso, adicionar filtros mais específicos, via backend para refletir melhor performance no front: data de criação (between), seleção múltipla de assuntos e autores para encontrar livros.

-------
## Considerações finais

Sugestões são super bem vindas.

Agradeço pela sua atenção.

-------
@marinapelosi





