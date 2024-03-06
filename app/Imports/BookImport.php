<?php

namespace App\Imports;

use App\Models\BookDetail;
use Maatwebsite\Excel\Concerns\ToModel;

class BookImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BookDetail([
            'book_name' => $row[0],
            'book_title' => $row[1],
            'author_name' => $row[2],
            'author_email' => $row[3],
            'book_edition' => $row[4],
            'description' => $row[5],
            'book_cover' => $row[6],
            'book_price' => $row[7],
            'book_language' => $row[8],
            'book_type' => $row[9],
            'book_discount' => $row[10],
        ]);
    }
}
