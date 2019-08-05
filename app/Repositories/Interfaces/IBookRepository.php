<?php
namespace App\Repositories\Interfaces;

Interface IBookRepository
{

    public static function getAllBooks();

    public static function getBookById($id);

    public static function storeBook($data);

    public static function updateBook($id, $isbn, $title, $description, $author, $quantity);

    public static function destroyBook($id);
}