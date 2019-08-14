<?php

namespace App\Services;

use App\Traits\Permissible;
use App\Exceptions\BookException;
use App\Repositories\BookRepository;
use App\Services\Interfaces\IBookService;

class BookService implements IBookService
{
    use Permissible;

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

    public function getBookById($book_id)
    {
        $book = BookRepository::getBookById($book_id);

        if(is_null($book))
        {
            throw new BookException("Book Not Found", 404);
        }

        return $book;
    }

    public function storeBook($isbn, $title, $description, $author, $quantity, $user_id)
    {
        return BookRepository::storeBook($isbn, $title, $description, $author, $quantity, $user_id);
    }

    public function updateBook($book_id, $isbn, $title, $description, $author, $quantity, $user_id)
    {
        BookRepository::updateBook($book_id, $isbn, $title, $description, $author, $quantity, $user_id);
    }

    public function destroyBook($book_id)
    {
        BookRepository::destroyBook($book_id);
    }

    public function ensureUserOwnsTheBook($book_id, $user_id)
    {
        $book = $this->getBookById($book_id);

        if ($book->user_id !== $user_id )
        {
            throw new BookException("Forbidden", 403);
        }
    }
}
