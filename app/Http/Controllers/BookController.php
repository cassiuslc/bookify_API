<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

/**
 * @OA\Info(
 *     title="Bookify,
 *     version="1.0.0",
 *     description="O objetivo do projeto é fornecer uma API RESTful para permitir que os usuários realizem diversas operações relacionadas a livros"
 * )
 */
/**
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     securityScheme="bearerAuth"
 * )
 */
class BookController extends Controller
{

/**
 * @OA\Get(
 *     path="/api/books/{id?}",
 *     operationId="listBooks",
 *     summary="Listar todos os Livros",
 *     tags={"Livros"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do livro (opcional)",
 *         required=false,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Número da página para paginação dos resultados",
 *         required=false,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="limit",
 *         in="query",
 *         description="Número de itens por página para paginação dos resultados",
 *         required=false,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="sort",
 *         in="query",
 *         description="Ordenação dos resultados",
 *         required=false,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="filter",
 *         in="query",
 *         description="Filtro para buscar por título, autor, etc.",
 *         required=false,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Sucesso",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Book")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro de solicitação inválida"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Livro não encontrado"
 *     )
 * )
 */
    public function index(Request $request, $id = null)
    {
        $books = $this->search($request, $id);

        return response()->json($books);
    }

    //Controla a Busca
    private function search(Request $request, $id = null)
    {
        if ($id !== null) {
            $books = $this->applySearch($id);
        }else{
            $query = $this->applyFilters($request);
            $this->applySorting($request, $query);
            $books = $this->retrieveBooks($request, $query);
        }
        return $books;
    }

    //Aplica os Filtros se eles existirem
    private function applyFilters(Request $request)
    {
        $query = Book::query();

        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $query->where('title', 'like', "%$filter%")
                ->orWhere('author', 'like', "%$filter%");
        }

        return $query;
    }

    //Aplica ordenação se ela existir
    private function applySorting(Request $request, $query)
    {
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $query->orderBy($sort);
        }
    }

    //Limita a resposta se limite e pagina existir se nao exibe tudo
    private function retrieveBooks(Request $request, $query)
    {
        if ($request->has('limit')) {
            $limit = $request->input('limit');
            $query->limit($limit);
        }

        if ($request->has('page')) {
            $page = $request->input('page', 1);
            return $query->paginate($limit ?? 10, ['*'], 'page', $page);
        }

        return $query->get();
    }

    /**
     * Obter detalhes de um livro específico.
     */
    private function applySearch($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return [];
        }

        return $book;
    }

/**
 * @OA\Post(
 *     path="/api/books",
 *     operationId="createBook",
 *     summary="Criar Livro",
 *     tags={"Livros"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="author_id", type="integer"),
 *             @OA\Property(property="genres_id", type="integer"),
 *             @OA\Property(property="edition", type="integer"),
 *             @OA\Property(property="year", type="integer"),
 *             @OA\Property(property="pages", type="integer"),
 *             @OA\Property(property="format", type="string"),
 *             @OA\Property(property="license", type="string"),
 *             @OA\Property(property="description", type="string", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Livro criado com sucesso",
 *         @OA\JsonContent(ref="#/components/schemas/Book")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro de solicitação inválida",
 *         @OA\JsonContent(
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * )
 */
    public function createBook(Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);

        if(!$data){
            return response()->json(['errors' => 'JSON not sent or invalid'], 400);
        }

        $validator = Validator::make($data, [
            'title' => 'required|string',
            'author_id' => 'required|integer|exists:authors,id',
            'genres_id' => 'required|integer|exists:genres,id',
            'edition' => 'required|integer',
            'year' => 'required|integer',
            'pages' => 'required|integer',
            'format' => 'required|string',
            'license' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $book = Book::create($data);

        return response()->json($book, 201);
    }

/**
 * @OA\Put(
 *     path="/api/books/{id}",
 *     operationId="updateBook",
 *     summary="Atualizar Livro",
 *     tags={"Livros"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do livro a ser atualizado",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="author_id", type="integer"),
 *             @OA\Property(property="genres_id", type="integer"),
 *             @OA\Property(property="edition", type="integer"),
 *             @OA\Property(property="year", type="integer"),
 *             @OA\Property(property="pages", type="integer"),
 *             @OA\Property(property="format", type="string"),
 *             @OA\Property(property="license", type="string"),
 *             @OA\Property(property="description", type="string", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Livro atualizado com sucesso",
 *         @OA\JsonContent(ref="#/components/schemas/Book")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro de solicitação inválida",
 *         @OA\JsonContent(
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Livro não encontrado"
 *     )
 * )
 */
    public function updateBook(Request $request, $id)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);

        if(!$data){
            return response()->json(['errors' => 'JSON not sent or invalid'], 400);
        }

        $validator = Validator::make($data, [
            'title' => 'string',
            'author_id' => 'integer|exists:authors,id',
            'genres_id' => 'integer|exists:genres,id',
            'edition' => 'integer',
            'year' => 'integer',
            'pages' => 'integer',
            'format' => 'string',
            'license' => 'string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $book = Book::find($id);

        if (!$book) {
            return response()->json(['errors' => 'Livro não encontrado'], 404);
        }

        $book->fill($data);
        $book->save();

        return response()->json($book, 200);
    }

/**
 * @OA\Delete(
 *     path="/api/books/{id}",
 *     operationId="deleteBook",
 *     summary="Excluir Livro",
 *     tags={"Livros"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do livro a ser excluído",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Livro excluído com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Livro não encontrado"
 *     )
 * )
 */
    public function deleteBook($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['errors' => 'Livro não encontrado'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Livro excluído com sucesso'], 200);
    }

/**
 * @OA\Get(
 *     path="/api/list/authors",
 *     operationId="getAllAuthors",
 *     summary="Listar todos os autores",
 *     tags={"Autores"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de todos os autores",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Author")
 *         )
 *     )
 * )
 */
    public function getAllAuthors()
    {
        $authors = Author::all();

        return response()->json($authors, 200);
    }

/**
 * @OA\Get(
 *     path="/api/list/genres",
 *     operationId="getAllGenres",
 *     summary="Listar todos os gêneros",
 *     tags={"Gêneros"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de todos os gêneros",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Genre")
 *         )
 *     )
 * )
 */
    public function getAllGenres()
    {
        $genres = Genre::all();

        return response()->json($genres, 200);
    }

/**
 * @OA\Get(
 *     path="/api/list/books",
 *     operationId="getAllBooks",
 *     summary="Listar todos os livros",
 *     tags={"Livros"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de todos os livros",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Book")
 *         )
 *     )
 * )
 */
    public function getAllBooks()
    {
        $genres = Book::all();

        return response()->json($genres, 200);
    }

}
