<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Interfaces\IBookRepository;

class BookRepository implements IBookRepository
{

    public static function getAllBooks(){
        return Book::all();
    }

    public static function getBooksByUserId($userId){
        return Book::where('user_id', $userId)->get();
    }

    public static function getBookById($id){
        return Book::find($id);
    }

    public static function storeBook($isbn, $title, $description, $author, $quantity, $user_id){
        $fields = compact('isbn', 'title', 'description', 'author', 'quantity', 'user_id');
        return Book::create($fields);
    }

    public static function updateBook($id, $isbn, $title, $description, $author, $quantity, $user_id){
        $fields = array_filter(compact('isbn', 'title', 'description', 'author', 'quantity', 'user_id'));
        return Book::where(['id'=> $id ])->update($fields);
    }

    public static function destroyBook($id){
        return Book::where('id', $id)->delete();
    }
}