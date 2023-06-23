
# Bookify

O objetivo do projeto é fornecer uma API RESTful para permitir que os usuários realizem diversas operações relacionadas a livros, como cadastrar livros, buscar por título ou autor, adicionar avaliações e comentários. A API será construída utilizando o framework Laravel e terá como banco de dados o MySQL.




## Rodando localmente

Clone o projeto

```bash
  git clone https://github.com/cassiuslc/Bookify
```

Entre no diretório do projeto

```bash
  cd bookify
```


## Variáveis de Ambiente

Para rodar esse projeto, você vai precisar adicionar as seguintes variáveis de ambiente no seu .env

`token-jwt`


## Cabeçalho

A API do Bookify utiliza autenticação baseada em JWT, sendo incluindo no header das solicitações, o token cadastrado no arquivo .env

`Authorization: Bearer <token-jwt>`


## Documentação da API

#### Listar todos os livros
Retorna todos os livros cadastrados no sistema.
```https
  GET /api/books
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `page` | `integer` | **Opcional**. Número da página para paginação dos resultados. |
| `limit` | `integer` | **Opcional**. Número da página para paginação dos resultados. |
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

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `ainda a pensar`      | `ainda a pensar` | **Obrigatório**. ainda a pensar. |

#### Atualizar os detalhes de um livro
Atualiza os detalhes de um livro no ID.

```https
  PUT /api/books/{id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `integer` | **Obrigatório**. ID do livro a ser atualizado. |
| `ainda a pensar`      | `ainda a pensar` | **Obrigatório**. ainda a pensar. |

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

