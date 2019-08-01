<?php

namespace App\Services;

use App\Models\Book;
use App\Services\Interfaces\IBookService;

class BookService //implements IBookService
{
    public function getAll(){
        $books = Book::all();
        return $books;
    }

    public function getOneById($id){
        $book = Book::find($id);

        if(!$book){
            return "not found"; // throw not found exception
        }

        return $book;
    }

    public function storeOne($data){
        return Book::create($data);
    }

    public function update($data, $id){
        $book = Book::find($id);

        if(!$book){
            return "no such book exists"; // throw not found exception
        }

        $book->update($data);
        return $book;
    }

    public function delete($data){
    }
}