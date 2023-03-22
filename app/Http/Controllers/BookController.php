<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class BookController extends Controller
{
    public function index()
    {
        //return Book::all(); // SQL STMT  -> SELECT * FROM books;
        $books = Book::all();
        return view('book.index',[
        'title'=> 'รายการข้อมูลหนังสือ',
        'books'=> $books

        ]);
    }
    public function create()
    {
        return view('book.create',['title'=>'เพิ่มข้อมูลหนังสือ']);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:books|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        $book = new Book;
        $book->name = $request->name;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();

        return redirect('/book');
    }
    public function edit($id)
    {
        $book = Book::find($id);
        return view('book.edit', [

            'title' => 'เเก้ไขข้อมูล',
            'book' => $book,
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', Rule::unique('books')->ignore($id)],
            'description' => 'required',
            'status' => 'required',
        ]);
        $book =  Book::find($id);
        $book->name = $request->name;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();

        return redirect('/book');
    }

}
