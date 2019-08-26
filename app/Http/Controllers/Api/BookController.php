<?php

namespace App\Http\Controllers\Api;

use App\Services\BookService;
use App\Services\ResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Constants\ResponseMessageConstants;
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

        return ResponseService::getSuccessResponse($books);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $book = $this->bookService->getBookForUser($id, Auth::user()->id);

        return ResponseService::getSuccessResponse($book);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $created_book = $this->bookService->storeBook(
            $request->isbn,
            $request->title,
            $request->description,
            $request->author,
            $request->quantity,
            Auth::user()->id
        );

        return ResponseService::getSuccessResponse($created_book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request)
    {
        $updated_book = $this->bookService->updateBook(
            $request->id,
            $request->isbn,
            $request->title,
            $request->description,
            $request->author,
            $request->quantity,
            Auth::user()->id
        );

        return ResponseService::getSuccessResponse($updated_book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->bookService->destroyBook($id, Auth::user()->id);
        return ResponseService::getSuccessResponse([], ResponseMessageConstants::BOOK_DELETED);
    }
}
