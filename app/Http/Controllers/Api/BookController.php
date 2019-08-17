<?php

namespace App\Http\Controllers\Api;

use App\Constants;
use App\Services\BookService;
use App\Services\ResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Lib\Responses\SuccessResponse;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Exceptions\Resource\ResourceForbiddenAccessException;

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
        return ResponseService::getResponse(
            new SuccessResponse($books)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = $this->bookService->getBookForUser($id, Auth::user()->id);

        return ResponseService::getResponse(
            new SuccessResponse($book)
        );
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

        return ResponseService::getResponse(
            new SuccessResponse($created_book)
        );
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

        return ResponseService::getResponse(
            new SuccessResponse($updated_book, Constants::BOOK_UPDATED)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->bookService->destroyBook($id, Auth::user()->id);

        return ResponseService::getResponse(
            new SuccessResponse(NULL, Constants::BOOK_DELETED)
        );
    }
}
