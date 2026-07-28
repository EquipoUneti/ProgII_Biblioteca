@extends('layouts.app')

@section('title', 'Entradas y Salidas - Control de Movimientos')

@section('content')
<div class="mb-4">
    <h1 class="h2 fw-bold text-dark mb-1">Entradas y Salidas de Inventario</h1>
    <p class="text-muted">Registra y visualiza el historial de movimientos de libros en almacén.</p>
</div>

<div class="row">
    <!-- Form Side -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm position-sticky" style="top: 20px;">
            <div class="card-header py-3 bg-white border-bottom">
                <h5 class="card-title mb-0 fw-bold text-secondary">
                    <i class="fa-solid fa-right-left me-2 text-primary"></i>Registrar Movimiento
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('movements.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="book_id" class="form-label fw-semibold">Seleccionar Libro <span class="text-danger">*</span></label>
                        <select class="form-select rounded-3 p-3 @error('book_id') is-invalid @enderror" id="book_id" name="book_id" required>
                            <option value="" disabled selected>-- Seleccione un libro --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }} (Stock: {{ $book->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label fw-semibold">Tipo de Movimiento <span class="text-danger">*</span></label>
                        <select class="form-select rounded-3 p-3 @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="entrada" {{ old('type') == 'entrada' ? 'selected' : '' }}>Entrada (Incrementar Stock)</option>
                            <option value="salida" {{ old('type') == 'salida' ? 'selected' : '' }}>Salida (Disminuir Stock)</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label fw-semibold">Cantidad <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control rounded-3 p-3 @error('quantity') is-invalid @enderror" 
                               id="quantity" 
                               name="quantity" 
                               min="1" 
                               value="{{ old('quantity', 1) }}" 
                               required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="note" class="form-label fw-semibold">Nota / Observación</label>
                        <textarea class="form-control rounded-3 p-3 @error('note') is-invalid @enderror" 
                                  id="note" 
                                  name="note" 
                                  rows="3" 
                                  placeholder="Ej: Donación de alumnos, Ajuste anual, Dañado...">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3">
                        <i class="fa-solid fa-circle-check me-2"></i>Aplicar Transacción
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- History Side -->
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header py-3 bg-white border-bottom">
                <h5 class="card-title mb-0 fw-bold text-secondary">
                    <i class="fa-solid fa-history me-2 text-primary"></i>Historial de Movimientos
                </h5>
            </div>
            <div class="card-body p-0">
                @if($movements->isEmpty())
                    <div class="text-center py-5">
                        <i class="fa-solid fa-clock-rotate-left text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-secondary fw-semibold">Sin movimientos registrados</h5>
                        <p class="text-muted">Aún no se han realizado entradas ni salidas.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha y Hora</th>
                                    <th scope="col">Libro / ISBN</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col" class="text-end">Cantidad</th>
                                    <th scope="col">Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movements as $movement)
                                    <tr>
                                        <td class="text-muted" style="font-size: 0.9rem;">
                                            {{ $movement->created_at->format('d/m/Y H:i:s') }}
                                        </td>
                                        <td>
                                            @if($movement->book)
                                                <div class="fw-semibold text-dark">{{ $movement->book->title }}</div>
                                                <div class="text-muted small">ISBN: {{ $movement->book->isbn }}</div>
                                            @else
                                                <span class="text-danger italic">Libro Eliminado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($movement->type === 'entrada')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 0.85rem;">
                                                    <i class="fa-solid fa-arrow-down-long me-1"></i> Entrada
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="font-size: 0.85rem;">
                                                    <i class="fa-solid fa-arrow-up-long me-1"></i> Salida
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end fw-bold {{ $movement->type === 'entrada' ? 'text-success' : 'text-danger' }}">
                                            {{ $movement->type === 'entrada' ? '+' : '-' }}{{ $movement->quantity }}
                                        </td>
                                        <td class="text-muted small" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $movement->note ?? '---' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
