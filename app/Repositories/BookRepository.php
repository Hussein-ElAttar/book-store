<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Interfaces\IBookRepository;

class BookRepository implements IBookRepository
{

    public static function getAllBooks(){
        return Book::all();
    }

    public static function getBookById($id){
        return Book::find($id);
    }

    public static function storeBook($data){
        return Book::create($data);
    }

    public static function updateBook($id, $isbn, $title, $description, $author, $quantity){
        $fields = array_filter(compact('isbn', 'title', 'description', 'author', 'quantity'));
        return Book::where(['id'=> $id ])->update($fields);
    }

    public static function destroyBook($id){
        return Book::where('id', $id)->delete();
    }
}