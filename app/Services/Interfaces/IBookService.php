<?php

namespace App\Services\Interfaces;

class BookService implements IBookService
{
    public function getAllBooks(){
    }

    public function getBookById($id){
    }

    public function storeBook($data){
    }

    public function updateBook($id, $isbn, $title, $description, $author, $quantity){
    }

    public function destroyBook($id){
    }
}