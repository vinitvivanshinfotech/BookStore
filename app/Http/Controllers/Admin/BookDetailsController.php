<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\saveBookRequest;
use App\Http\Requests\updateBookRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\VarDumper\VarDumper;
use Illuminate\Support\Facades\Response;
use DB;


use App\Repositories\Interfaces\BookDetailsRepositoryInterface;
// use App\Services\UrlService;

class BookDetailsController extends Controller
{
    protected $bookDetails;

    /**
     * Desciption : 
     *
     * @param BookDetailsRepositoryInterface $bookDetails
     * @return : 
     */
    public  function __construct(
        BookDetailsRepositoryInterface  $bookDetails
    ) {
        $this->bookDetails = $bookDetails;
    }
    /**
     * Desciption : This function which used to save the book in database.
     *
     * @param :request
     * @return :
     */
    public function bookAdd(saveBookRequest $request)
    {
        try {

            DB::beginTransaction();
            $data = $request->except('book_cover', '_token');

            $file_name = uniqid() . '_' . time() . '.' . $request->book_cover->getClientOriginalExtension();
            $file_path = "uploads/books_covers/$file_name";
            Storage::disk(config('constant.FILESYSTEM_DISK'))->put($file_path, file_get_contents($request->book_cover));
            $data['book_cover'] = $file_path;

            $this->bookDetails->addbook($data);

            Log::info('successfully adding new book database by admin ');
            DB::commit();
            return redirect()->route('showAll.books')->with("success", 'Book added successfully!');
        } catch (\Exception $e) {
            // return to adding new book page with error
            Log::error('Error while Adding the new book : ' . ': ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Desciption : This function fetch all bookes from the dataabse
     * and  show them on the show all book page.
     * @param :
     * @return : all_books
     */
    public function showAllBookBook()
    {
        try {
            $books = $this->bookDetails->fetchallbook();
            Log::info('Getting all books from dabase by admin ');
            return view('Admin.show_all_book', compact('books'));
        } catch (\Exception $e) {
            Log::error('Error while fetching all book : ' . ': ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Desciption : This function fetch the one book from the dataabse
     * and  show them on the edit book page.
     * @param : id
     * @return : book,book_edition,book_language,book_type
     */
    public function bookEditShow($id)
    {
        try {
            // Find the book by ID
            $bookId = (int)($id);
            $book = $this->bookDetails->findbook($bookId);

            // Explode the book properties into separate arrays
            $bookEdition = explode(',', $book->book_edition);
            $bookLanguage = explode(',', $book->book_language);
            $bookType = explode(',', $book->book_type);

            // Log the action
            Log::info("Updating book details with ID: {$bookId}.");
            return view("Admin.edit_book", [
                "book" => $book,
                'bookEdition' => $bookEdition,
                'bookLanguage' => $bookLanguage,
                'bookType' => $bookType,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Log the error
            Log::error("Book not found with ID: {$id}.");
            return Response::json(['error' => 'Book not found.'], 404);
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error while showing book details with ID: {$id}: {$e->getMessage()}.");
            return Response::json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Desciption : This function update the book in the database.
     *
     * @param : request
     * @return : 
     */
    public function bookUpdate(updateBookRequest $request)
    {
        try {
            DB::beginTransaction();
            $book = $this->bookDetails->findbook($request->id);

            $data = $request->except('book_cover');
            if ($request->book_cover != null) {

                $this->deleteBookCover($book);

                $file_name = uniqid() . '_' . time() . '.' . $request->book_cover->getClientOriginalExtension();
                $file_path = "uploads/books_covers/$file_name";
                Storage::disk(config('constant.FILESYSTEM_DISK'))->put($file_path, file_get_contents($request->book_cover));
                $data['book_cover'] = $file_path;
            }
            $book->update($data);
            Log::info('Updateing the book details  with id: ' . $request->id . '.');
            DB::commit();
            return redirect()->route('showAll.books')->with("success", 'Book Updated Successfully ');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in updating book details with id : ' . $request->id . ': ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Desciption : This function is used for deleting a specific book from database by its id .
     *
     * @param :id
     * @return : 
     */
    public function bookDelete($id)
    {

        try {
            DB::beginTransaction();
            $book = $this->bookDetails->findBook($id);
            $this->deleteBookCover($book);
            $this->deleteBookRecord($id);
            Log::info('Deleted book with id: ' . $id);
            DB::commit();
            return redirect()->route("showAll.books")->with("success", "Successfully deleted the book");
        } catch (\Exception $e) {
            Log::error('Failed to delete book with id ' . $id . ': ' . $e->getMessage());
            return response()->json(['message' => "Error in deleting this book"], 500);
        }
    }

    /**
     * Desciption : Deleting the book cover
     *
     * @param : Book Delete Cover
     * @return : 
     */
    private function deleteBookCover($book)
    {
        try {
            if (Storage::disk(config('constant.FILESYSTEM_DISK'))->exists($book->book_cover)) {
                Storage::disk(config('constant.FILESYSTEM_DISK'))->delete($book->book_cover);
            }
            log::info('successfully delete the image');
        } catch (FileNotFoundException $exception) {
            log::error('file not found error ', $exception);
        }
    }

    /**
     * Desciption : 
     *
     * @param :
     * @return : 
     */
    private function deleteBookRecord($id)
    {
        if (null !== $id && $id > 0) {
            DB::transaction(function () use ($id) {
                $this->bookDetails->deleteBook($id);
            });
        }
    }
}
