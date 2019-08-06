<?php

namespace App\Services;

use App\Exceptions\BookException;
use App\Repositories\BookRepository;
use Illuminate\Support\Facades\Auth;

class BookService //implements IBookService
{
    public function getAllBooks(){
        $books = BookRepository::getAllBooks();
        return $books;
    }

    public function getUserBooks(){
        $books = BookRepository::getBooksByUserId(Auth::user()->id);
        return $books;
    }

    public function getBookById($id){
        $book = BookRepository::getBookById($id);

        if(is_null($book)){
            throw new BookException("Book Not Found", 404);
        }
        else if ($book->user_id !== Auth::user()->id){
            throw new BookException("Forbidden", 403);
        }

        return $book;
    }

    public function storeBook($isbn, $title, $description, $author, $quantity){
        $user_id = Auth::user()->id;
        return BookRepository::storeBook($isbn, $title, $description, $author, $quantity, $user_id);
    }

    public function updateBook($id, $isbn, $title, $description, $author, $quantity){
        $this->getBookById($id);
        $user_id = Auth::user()->id;
        BookRepository::updateBook($id, $isbn, $title, $description, $author, $quantity, $user_id);
    }

    public function destroyBook($id){
        $this->getBookById($id);
        BookRepository::destroyBook($id);
    }
}