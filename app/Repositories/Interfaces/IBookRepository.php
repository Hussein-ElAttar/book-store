<?php
namespace App\Repositories\Interfaces;

Interface IBookRepository
{

    public static function getAllBooks();

    public static function getBookById($id);

    public static function storeBook($isbn, $title, $description, $author, $quantity, $user_id);

    public static function updateBook($id, $isbn, $title, $description, $author, $quantity, $user_id);

    public static function destroyBook($id);
}