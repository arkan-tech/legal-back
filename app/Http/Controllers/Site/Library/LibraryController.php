<?php

namespace App\Http\Controllers\Site\Library;

use App\Http\Controllers\Controller;
use App\Models\Library\Books\Book;
use App\Models\Library\LibraryCat;
use App\Models\Library\LibraryFavorite;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        $Librarycats = LibraryCat::where('parent','0')->OrderBy('created_at','desc')->get();
        return view('site.library.library',compact('Librarycats'));
    }

    public function search (Request $request)
    {
        if(!$request->search){
            $Librarycats = LibraryCat::where('parent','0')->get();
            return view('site.library.library',compact('Librarycats'));
        }
        $Librarycats= LibraryCat::where('title','LIKE','%'.$request->search.'%')->where('parent','!=','0')->get();
        $Books = Book::where('Title','LIKE','%'.$request->search.'%')->get();
        return view('site.library.library-search',compact('Librarycats','Books'));

    }


    public function show ($id)
    {
        $Books = Book::where('CatID',$id)->get();
        $sectitle= GetName('librarycats','title','id',$id);
        return view('site.library.libraryview',compact('Books','sectitle'));
    }
    public function pdfview ($id)
    {
        $sectitle= GetName('books','title','id',$id);

        $Book = Book::where('id',$id)->first();
        // $parent= GetName('librarycats','title','id',$Book->CatID);
        $BK =  Book::where('id',$Book->CatID)->first();

        // $pdf =  Storage::url($Book->Link);

        return view('site.library.pdf-view',compact('sectitle','Book','BK'));
    }

    public function checkBookFavorite(Request $request)
    {
        $check_favorite = LibraryFavorite::where('admin_id', $request->lawyerID)->where('book_id', $request->bookID)->first();

        $book = Book::where('id', $request->bookID)->first();

        if($check_favorite){

            $check_favorite->delete();

            return response()->json(['success'=> 0]);
        }else{

            $updated_at = Carbon::now()->toDateTimeString();
            $dateTime = date('Y-m-d H:i:s',strtotime('+2 hours',strtotime($updated_at)));

            $new_favorite = new LibraryFavorite;

            $new_favorite->admin_id = $request->lawyerID;
            $new_favorite->book_id = $request->bookID;
            $new_favorite->link = $book->Link;
            $new_favorite->book_name = $book->Title;
            $new_favorite->created_at = $dateTime ;
            $new_favorite->updated_at = $dateTime ;

            $new_favorite->save();

            return response()->json(['success'=> 1]);
        }

    }
}
