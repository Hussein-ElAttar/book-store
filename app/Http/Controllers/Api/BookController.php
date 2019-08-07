<?php

namespace App\Http\Controllers\Api;

use App\Services\BookService;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = $this->bookService->getUserBooks();

        return response()->json($books);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = $this->bookService->getBookById($id);

        return response()->json($book);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $data = $request->all();
        $description = $data['description'];
        $quantity    = $data['quantity'];
        $author      = $data['author'];
        $title       = $data['title'];
        $isbn        = $data['isbn'];

        $createdBook = $this->bookService->storeBook(
            $isbn, $title, $description, $author, $quantity
        );

        return response()->json($createdBook);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $data = $request->all();
        $description = $data['description'] ?? NULL;
        $quantity    = $data['quantity'] ?? NULL;
        $author      = $data['author'] ?? NULL;
        $title       = $data['title'] ?? NULL;
        $isbn        = $data['isbn'] ?? NULL;

        $this->bookService->updateBook(
            $id, $isbn, $title, $description, $author, $quantity
        );

        return Response::json(['message'=>'Book Updated Successfully'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->bookService->destroyBook($id);

        return Response::json(['message'=>'Book Deleted Successfully'], 200);
    }
}
