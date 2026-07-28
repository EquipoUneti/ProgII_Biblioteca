@extends('layouts.app')

@section('title', 'Control de Libros - Existencias')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 fw-bold text-dark mb-1">Control de Libros</h1>
        <p class="text-muted mb-0">Listado general de títulos y existencias de la biblioteca</p>
    </div>
    <a href="{{ route('books.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Registrar Nuevo Libro
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($books->isEmpty())
            <div class="text-center py-5">
                <i class="fa-solid fa-book-open text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-secondary fw-semibold">No hay libros registrados</h5>
                <p class="text-muted">Comienza registrando tu primer libro en el sistema.</p>
                <a href="{{ route('books.create') }}" class="btn btn-primary btn-sm mt-2">Registrar Libro</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 80px;">ID</th>
                            <th scope="col">Título</th>
                            <th scope="col">Autor</th>
                            <th scope="col">ISBN</th>
                            <th scope="col" style="width: 150px;">Existencias</th>
                            <th scope="col" style="width: 200px;" class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                            <tr>
                                <td class="text-muted fw-bold">#{{ $book->id }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $book->title }}</div>
                                </td>
                                <td>{{ $book->author }}</td>
                                <td>
                                    <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.85rem;">
                                        {{ $book->isbn }}
                                    </span>
                                </td>
                                <td>
                                    @if($book->stock > 0)
                                        <span class="stock-badge stock-in">
                                            <i class="fa-solid fa-circle-check"></i> {{ $book->stock }} disponibles
                                        </span>
                                    @else
                                        <span class="stock-badge stock-out">
                                            <i class="fa-solid fa-triangle-exclamation"></i> Sin existencias
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-3" title="Editar libro">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este libro? Se borrarán también todos sus movimientos asociados.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-3" title="Eliminar libro">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
