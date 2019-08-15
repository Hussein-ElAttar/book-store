<?php

namespace App\Http\Controllers\Api;

use App\Services\BookService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = $this->bookService->getUserBooks(Auth::user()->id);

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

        $this->ensureUserOwnsTheBook($id, Auth::user()->id);

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
        $createdBook = $this->bookService->storeBook(
            $request->isbn,
            $request->title,
            $request->description,
            $request->author,
            $request->quantity,
            Auth::user()->id
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
        $this->ensureUserOwnsTheBook($id, Auth::user()->id);

        $this->bookService->updateBook(
            $request->id,
            $request->isbn,
            $request->title,
            $request->description,
            $request->author,
            $request->quantity,
            Auth::user()->id
        );

        return Response::json(self::BOOK_UPDATED, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->ensureUserOwnsTheBook($id, Auth::user()->id);

        $this->bookService->destroyBook($id);

        return Response::json(['message'=>'Book Deleted Successfully'], 200);
    }
}
