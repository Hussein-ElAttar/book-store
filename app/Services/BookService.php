<?php

namespace App\Services;

use App\Constants\ExceptionConstants;
use App\Exceptions\CustomException;
use App\Repositories\BookRepository;

class BookService
{
    public function getAllBooks()
    {
        $books = BookRepository::getAllBooks();

        return $books;
    }

    public function getUserBooks($user_id)
    {
        $books = BookRepository::getBooksByUserId($user_id);

        return $books;
    }

    public function getBookForUser($book_id, $user_id)
    {
        $book = $this->getBookById($book_id);
        $this->ensureUserOwnsTheBookByModel($book, $user_id);
        return $book;
    }


    public function storeBook($isbn, $title, $description, $author, $quantity, $user_id)
    {
        return BookRepository::storeBook($isbn, $title, $description, $author, $quantity, $user_id);
    }

    public function updateBook($book_id, $isbn, $title, $description, $author, $quantity, $user_id)
    {
        $this->ensureUserOwnsTheBookById($book_id, $user_id);
        return BookRepository::updateBook($book_id, $isbn, $title, $description, $author, $quantity, $user_id);
    }

    public function destroyBook($book_id, $user_id)
    {
        $this->ensureUserOwnsTheBookById($book_id, $user_id);
        BookRepository::destroyBook($book_id);
    }

    public function getBookById($book_id)
    {
        $book = BookRepository::getBookById($book_id);

        if(is_null($book))
        {
            throw new CustomException(ExceptionConstants::RESOURCE_NOT_FOUND);
        }

        return $book;
    }

    private function ensureUserOwnsTheBookById($book_id, $user_id)
    {
        $book = $this->getBookById($book_id);
        $this->ensureUserOwnsTheBookByModel($book, $user_id);
    }

    private function ensureUserOwnsTheBookByModel($book, $user_id)
    {
        if ($book->user_id !== $user_id )
        {
            throw new CustomException(ExceptionConstants::RESOURCE_FORBIDDEN);
        }
    }
}
