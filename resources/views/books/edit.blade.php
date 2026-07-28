@extends('layouts.app')

@section('title', 'Editar Libro')

@section('content')
<div class="mb-4">
    <a href="{{ route('books.index') }}" class="text-decoration-none text-muted">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver al listado
    </a>
    <h1 class="h2 fw-bold text-dark mt-2 mb-1">Editar Libro</h1>
    <p class="text-muted">Modifica los detalles del libro registrado en el catálogo.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header py-3 bg-white border-bottom">
                <h5 class="card-title mb-0 fw-bold text-secondary">
                    <i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Modificar Datos
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Título del Libro <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control rounded-3 p-3 @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $book->title) }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="author" class="form-label fw-semibold">Autor <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control rounded-3 p-3 @error('author') is-invalid @enderror" 
                                   id="author" 
                                   name="author" 
                                   value="{{ old('author', $book->author) }}" 
                                   required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="isbn" class="form-label fw-semibold">ISBN <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control rounded-3 p-3 @error('isbn') is-invalid @enderror" 
                                   id="isbn" 
                                   name="isbn" 
                                   value="{{ old('isbn', $book->isbn) }}" 
                                   required>
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary px-4 py-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Actualizar Libro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="card bg-light border-0 shadow-none">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="fa-solid fa-circle-info text-primary me-2"></i>Información Adicional</h5>
                <p class="text-muted small">
                    El stock actual de este libro es de <strong>{{ $book->stock }} unidades</strong>. 
                </p>
                <p class="text-muted small text-warning">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i>
                    Las existencias de stock no se pueden modificar directamente editando el libro. Esto protege la trazabilidad. 
                    Por favor, use el módulo de <a href="{{ route('movements.index') }}" class="fw-bold">Entradas y Salidas</a> para alterar el inventario.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
