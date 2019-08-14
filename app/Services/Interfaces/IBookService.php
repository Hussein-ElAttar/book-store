<?php

namespace App\Services\Interfaces;

interface IBookService
{
    public function getAllBooks();

    public function getUserBooks($user_id);

    public function getBookById($book_id);

    public function storeBook($isbn, $title, $description, $author, $quantity, $user_id);

    public function updateBook($book_id, $isbn, $title, $description, $author, $quantity, $user_id);

    public function destroyBook($book_id);

    public function ensureUserOwnsTheBook($book_id, $user_id);
}