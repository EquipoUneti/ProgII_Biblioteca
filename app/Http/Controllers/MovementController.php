<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = Movement::with('book')->orderBy('created_at', 'desc')->get();
        $books = Book::orderBy('title')->get();
        return view('movements.index', compact('movements', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'type' => 'required|in:entrada,salida',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ], [
            'book_id.required' => 'El libro es obligatorio.',
            'book_id.exists' => 'El libro seleccionado no existe.',
            'type.required' => 'El tipo de movimiento es obligatorio.',
            'type.in' => 'El tipo de movimiento no es válido.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',
            'quantity.min' => 'La cantidad debe ser al menos 1.',
            'note.max' => 'La nota no puede superar los 255 caracteres.'
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Find and lock the book row for update to prevent race conditions
                $book = Book::where('id', $validated['book_id'])->lockForUpdate()->firstOrFail();

                if ($validated['type'] === 'entrada') {
                    $book->stock += $validated['quantity'];
                } else { // salida
                    if ($book->stock < $validated['quantity']) {
                        throw new \Exception("Stock insuficiente para realizar esta salida. Stock actual: {$book->stock}.");
                    }
                    $book->stock -= $validated['quantity'];
                }

                $book->save();

                Movement::create($validated);
            });

            return redirect()->route('movements.index')->with('success', 'Movimiento registrado y stock actualizado con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['quantity' => $e->getMessage()]);
        }
    }
}
