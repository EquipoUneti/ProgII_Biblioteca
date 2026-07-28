@extends('layouts.app')

@section('title', 'Registrar Nuevo Libro')

@section('content')
<div class="mb-4">
    <a href="{{ route('books.index') }}" class="text-decoration-none text-muted">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver al listado
    </a>
    <h1 class="h2 fw-bold text-dark mt-2 mb-1">Registrar Nuevo Libro</h1>
    <p class="text-muted">Agrega un nuevo título al catálogo de la biblioteca.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header py-3 bg-white border-bottom">
                <h5 class="card-title mb-0 fw-bold text-secondary">
                    <i class="fa-solid fa-book-medical me-2 text-primary"></i>Datos del Libro
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Título del Libro <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control rounded-3 p-3 @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               placeholder="Ej: Cien Años de Soledad" 
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
                                   value="{{ old('author') }}" 
                                   placeholder="Ej: Gabriel García Márquez" 
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
                                   value="{{ old('isbn') }}" 
                                   placeholder="Ej: 978-0307474728" 
                                   required>
                            <div class="form-text text-muted">Debe ser un código único identificador.</div>
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary px-4 py-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Libro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="card bg-light border-0 shadow-none">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="fa-solid fa-circle-info text-primary me-2"></i>Nota sobre Existencias</h5>
                <p class="text-muted small">
                    Al registrar un libro por primera vez, su stock inicial se define automáticamente en <strong>0</strong>. 
                </p>
                <p class="text-muted small">
                    Para asignar unidades disponibles al catálogo, deberás registrar una **Entrada** desde la sección de 
                    <a href="{{ route('movements.index') }}" class="fw-semibold text-primary">Entradas y Salidas</a> una vez creado el registro.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
