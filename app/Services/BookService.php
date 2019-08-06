<?php

namespace App\Services;

use App\Models\Book;
use App\Exceptions\BookException;
use App\Repositories\BookRepository;

class BookService //implements IBookService
{
    public function getAllBooks(){
        $books = BookRepository::getAllBooks();
        return $books;
    }

    public function getBookById($id){
        $book = BookRepository::getBookById($id);

        if(is_null($book)){
            throw new BookException("Book Not Found", 404);
        }

        return $book;
    }

    public function storeBook($data){
        return BookRepository::storeBook($data);
    }

    public function updateBook($id, $isbn, $title, $description, $author, $quantity){
        $updatedCount = BookRepository::updateBook($id, $isbn, $title, $description, $author, $quantity);
        if($updatedCount === 0){
            throw new BookException("Book Not Found", 404);
        }
    }

    public function destroyBook($id){
        if(BookRepository::destroyBook($id) === 0){
            throw new BookException("Book Not Found", 404);
        }
    }
}