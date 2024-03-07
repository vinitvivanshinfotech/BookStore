<?php

namespace App\Repositories;

use App\Models\BookDetail;
use App\Repositories\Interfaces\BookDetailsRepositoryInterface;

class BookDetailsRepository implements BookDetailsRepositoryInterface
{

    /**
     * Desciption : Add new book  detail to the database.
     *
     * @param array $data
     * 
     */

    public function addbook($data)
    {
        BookDetail::create($data);
    }

    /**
     * Desciption : Fetching all book details from the database.
     *
     * @param :  void
     * @return : void
     */
    public function fetchallbook()
    {
        return BookDetail::all();
    }

    /**
     * Desciption : Finding a specific book by its id and returning it's data.
     *
     * @param string $id
     * @return : void 
     */

    public function findbook($id)
    {
        $book = BookDetail::findOrFail($id);
        if ($book == null) {
            abort(404, 'book');
        }
        return  $book;
    }

    /**
     * Desciption : updaeting the book  information in the database.
     *
     * @param array  $data 
     * @return : void
     */
    public function updatebook($data)
    {
        $book = BookDetail::findorFail($data['id']);
        $book->update($data);
    }

    /**
     * Desciption : deleting the book with the given id from the database.
     *
     * @param string $id
     * @return : void
     */

    public function deletebook($id)
    {
        $book = BookDetail::findorFail($id);
        $book->delete();
    }
}
