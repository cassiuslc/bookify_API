
# Bookify

O objetivo do projeto é fornecer uma API RESTful para permitir que os usuários realizem diversas operações relacionadas a livros, como cadastrar livros, buscar por título ou autor. A API será construída utilizando o framework Laravel e terá como banco de dados o MySQL.




## Rodando localmente

Clone o projeto, presume que você já tem um ambiente laravel PHP com mysql.

```bash
  git clone https://github.com/cassiuslc/Bookify
```

Entre no diretório do projeto

```bash
  cd bookify
```

composer

```bash
composer install
php artisan key:generate
php artisan jwt:secret
php artisan migrate
```

## Variáveis de Ambiente

Para rodar esse projeto, você vai precisar adicionar as seguintes variáveis de ambiente no seu .env

`JWT_SECRET`
`DB_CONNECTION`
`DB_HOST`
`DB_PORT`
`DB_DATABAS`
`DB_USERNAME`
`DB_PASSWORD`


## Cabeçalho

A API do Bookify utiliza autenticação baseada em JWT, sendo incluindo no header das solicitações, o token cadastrado no arquivo .env

`Authorization: Bearer <token-jwt>`


## Documentação da API
#### Autenticação
Obtem o token de autenticação
```https
  POST /api/auth/login
```
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `email` | `email` | **Obrigatorio**. Email. |
| `password` | `password` | **Obrigatorio**. Senha. |

#### Listar todos os livros
Retorna todos os livros cadastrados no sistema.
```https
  GET /api/books
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id` | `integer` | **Opcional**. Obtem livro baseado no resultado do id, ignorando outros filtros. |
| `page` | `integer` | **Opcional**. Número da página para paginação dos resultados. |
| `limit` | `integer` | **Opcional**. Número da limite dos resultados. |
| `sort` | `string` | **Opcional**. Ordenação dos resultados |
| `filter` | `string` | **Opcional**. Filtro para buscar por título, autor, etc. |

#### Buscar livro
Obter detalhes de um livro específico

```https
  GET /api/books/{id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `integer` | **Obrigatório**. ID do livro a ser buscado. |



#### Criar um novo livro

Cria um novo livro com base nos dados.

```https
  POST /api/books
```

| Parâmetro    | Tipo    | Descrição                                     |
| :----------- | :------ | :-------------------------------------------- |
| `title`      | string  | **Obrigatório**. Título do livro.              |
| `author_id`  | integer | **Obrigatório**. ID do autor do livro.         |
| `genres_id`  | integer | **Obrigatório**. ID dos gêneros do livro.      |
| `edition`    | integer | **Obrigatório**. Edição do livro.              |
| `year`       | integer | **Obrigatório**. Ano de publicação do livro.   |
| `pages`      | integer | **Obrigatório**. Número de páginas do livro.   |
| `format`     | string  | **Obrigatório**. Formato do livro.             |
| `license`    | string  | **Obrigatório**. Licença do livro.             |
| `description`| string  | Descrição do livro (opcional).                 |


#### Atualizar os detalhes de um livro
Atualiza os detalhes de um livro no ID.

```https
  PUT /api/books/{id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | integer | **Obrigatório**. ID do livro a ser atualizado. |
| `title`      | string  | **Opcional**. Título do livro.              |
| `author_id`  | integer | **Opcional**. ID do autor do livro.         |
| `genres_id`  | integer | **Opcional**. ID dos gêneros do livro.      |
| `edition`    | integer | **Opcional**. Edição do livro.              |
| `year`       | integer | **Opcional**. Ano de publicação do livro.   |
| `pages`      | integer | **Opcional**. Número de páginas do livro.   |
| `format`     | string  | **Opcional**. Formato do livro.             |
| `license`    | string  | **Opcional**. Licença do livro.             |
| `description`| string  | **Opcional**. Descrição do livro.            |


#### Excluir um livro

Exclui um livro específico com base no ID.

```https
DELETE /api/books/{id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `integer` | **Obrigatório**. ID do livro a ser excluido. |

#### Buscar livros por titulo

buscar por titulo

```https
  GET /api/books/search?title={title}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `title`      | `string` | **Obrigatório**. Título do livro a ser buscado. |

#### Buscar livros por autor

buscar pelo autor

```https
  GET /api/books/search?author={author}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `string`      | `string` | **Obrigatório**. Autor do livro a ser buscado. |

## Autores

- [@cassiuslc](https://www.github.com/cassiuslc)


## Links

[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/cassiuslc)

