<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::orderBy('title')->get();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books,isbn',
        ], [
            'isbn.unique' => 'El ISBN ya está registrado para otro libro.',
            'title.required' => 'El título es obligatorio.',
            'author.required' => 'El autor es obligatorio.',
            'isbn.required' => 'El ISBN es obligatorio.'
        ]);

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Libro registrado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('books')->ignore($book->id),
            ],
        ], [
            'isbn.unique' => 'El ISBN ya está registrado para otro libro.',
            'title.required' => 'El título es obligatorio.',
            'author.required' => 'El autor es obligatorio.',
            'isbn.required' => 'El ISBN es obligatorio.'
        ]);

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Libro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Libro eliminado exitosamente.');
    }
}
