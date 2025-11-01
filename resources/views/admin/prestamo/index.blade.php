@extends('adminlte::page')

@section('title', 'Crud Libreria')

@section('content_header')
    <h1>{{ __('Prestamos') }}</h1>
@stop

@section('content')
    <div class="card">
        @if(session('success'))
            <div class="alert alert-success fade-out-display">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger fade-out-display">
                {{ session('error') }}
            </div>
        @endif
        <div class="card-header">
            <h3 class="card-title">Nuevo Préstamo</h3>
        </div>
        <form action="{{ route('admin.prestamos.store') }}" method="POST" id="form-prestamo" novalidate>
            @csrf
            <div class="card-body">
                <div class="row">
                    <!-- Primera columna -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estudiante_id">Estudiante</label>
                            <select class="form-control select2 @error('estudiante_id') is-invalid @enderror" id="estudiante_id" name="estudiante_id" required>
                                <option value="">Seleccione un estudiante</option>
                                @foreach($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id }}" {{ old('estudiante_id') == $estudiante->id ? 'selected' : '' }}>{{ $estudiante->name }}</option>
                                @endforeach
                            </select>
                            @error('estudiante_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Finalización</label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror" id="fecha_fin" 
                                       name="fecha_fin" required
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       value="{{ old('fecha_fin') }}"
                                       placeholder="Seleccione la fecha de finalización">
                                @error('fecha_fin')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Segunda columna -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio" 
                                       name="fecha_inicio" required
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('fecha_inicio') }}"
                                       placeholder="Seleccione la fecha de inicio">
                                @error('fecha_inicio')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3" 
                                placeholder="Ingrese una descripción del préstamo" maxlength="100">{{ old('descripcion') }}</textarea>
                            <small class="text-muted float-right"><span id="contador-caracteres">{{ strlen(old('descripcion', '')) }}</span>/100 caracteres</small>
                            @error('descripcion')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sección de Detalles del Préstamo -->
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">Detalles del Préstamo</h3>
                            <button type="button" class="btn btn-success btn-sm" id="agregar-libro">
                                <i class="fas fa-plus"></i> Agregar Libro
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="libros-container">
                            <!-- Libro inicial -->
                            <div class="row libro-item mb-3">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Libro</label>
                                        <select class="form-control select-libro @error('libros.0.libro_id') is-invalid @enderror" name="libros[0][libro_id]" required>
                                            <option value="" {{ old('libros.0.libro_id') ? '' : 'selected disabled' }}>Seleccione un libro</option>
                                            @foreach($libros as $libro)
                                                <option value="{{ $libro->id }}" {{ old('libros.0.libro_id') == $libro->id ? 'selected' : '' }}>{{ $libro->titulo }} - {{ $libro->autor }}</option>
                                            @endforeach
                                        </select>
                                        @error('libros.0.libro_id')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="number" class="form-control cantidad-libro @error('libros.0.cantidad') is-invalid @enderror" 
                                               name="libros[0][cantidad]" min="1" value="{{ old('libros.0.cantidad', 1) }}" required>
                                        @error('libros.0.cantidad')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center mt-3">
                                    <button type="button" class="btn btn-danger btn-eliminar-libro" disabled>
                                        <i class="fas fa-trash"></i> Quitar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer text-right">
                <button type="reset" class="btn btn-default mr-2">Limpiar</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </form>
    </div>
@stop

@push('js')
    <script>
        // Función para ocultar mensajes después de un tiempo
        function ocultarMensajes() {
            // Ocultar mensajes de éxito después de 5 segundos
            const mensajesExito = document.querySelectorAll('.alert-success');
            mensajesExito.forEach(mensaje => {
                setTimeout(() => {
                    mensaje.style.transition = 'opacity 0.5s';
                    mensaje.style.opacity = '0';
                    setTimeout(() => mensaje.remove(), 500);
                }, 5000);
            });

            // Ocultar mensajes de error después de 5 segundos
            const mensajesError = document.querySelectorAll('.alert-danger, .invalid-feedback');
            mensajesError.forEach(mensaje => {
                setTimeout(() => {
                    mensaje.style.transition = 'opacity 0.5s';
                    mensaje.style.opacity = '0';
                    setTimeout(() => mensaje.remove(), 500);
                }, 5000);
            });
        }

        

        document.addEventListener('DOMContentLoaded', function() {
            // Ocultar mensajes al cargar la página
            ocultarMensajes();
            
            // Configurar validación en tiempo real
            const form = document.getElementById('form-prestamo');
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                        const errorMsg = this.nextElementSibling;
                        if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                            errorMsg.style.display = 'none';
                        }
                    }
                });
                
                // Para los campos de fecha, validar cuando pierden el foco
                if (input.type === 'date') {
                    input.addEventListener('change', function() {
                        if (this.value) {
                            this.classList.remove('is-invalid');
                            const errorMsg = this.nextElementSibling;
                            if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                                errorMsg.style.display = 'none';
                            }
                        }
                    });
                }
            });

            let contadorLibros = 0;
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('cantidad-libro')) {
                    if (e.target.value < 1) {
                        e.target.value = 1;
                    }
                }
            });

            // Agregar nuevo libro
            document.getElementById('agregar-libro').addEventListener('click', function() {
                contadorLibros++;
                
                const nuevoLibro = `
                    <div class="row libro-item mb-3">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Libro</label>
                                <select class="form-control select-libro" name="libros[${contadorLibros}][libro_id]" required>
                                    <option value="">Seleccione un libro</option>
                                    @foreach($libros as $libro)
                                        <option value="{{ $libro->id }}">{{ $libro->titulo }} - {{ $libro->autor }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback d-none" id="libro-${contadorLibros}-error"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" class="form-control cantidad-libro" 
                                       name="libros[${contadorLibros}][cantidad]" min="1" value="1" required>
                                <div class="invalid-feedback d-none" id="cantidad-${contadorLibros}-error"></div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center mt-3">
                            <button type="button" class="btn btn-danger btn-eliminar-libro" disabled>
                                <i class="fas fa-trash"></i> Quitar
                            </button>
                        </div>
                    </div>
                `;
                
                document.getElementById('libros-container').insertAdjacentHTML('beforeend', nuevoLibro);
                actualizarBotonesEliminar();
            });

            // Eliminar libro
            function eliminarLibro(boton) {
                const items = document.querySelectorAll('.libro-item');
                if (items.length > 1) {
                    boton.closest('.libro-item').remove();
                    actualizarBotonesEliminar();
                }
            }

            // Actualizar estado de botones eliminar
            function actualizarBotonesEliminar() {
                const botones = document.querySelectorAll('.btn-eliminar-libro');
                const items = document.querySelectorAll('.libro-item');
                
                botones.forEach(boton => {
                    if (items.length === 1) {
                        boton.disabled = true;
                        boton.classList.add('disabled');
                    } else {
                        boton.disabled = false;
                        boton.classList.remove('disabled');
                    }
                });
            }

            // Delegación de eventos para botones eliminar
            document.getElementById('libros-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-eliminar-libro') || 
                    e.target.closest('.btn-eliminar-libro')) {
                    const boton = e.target.classList.contains('btn-eliminar-libro') ? 
                                 e.target : e.target.closest('.btn-eliminar-libro');
                    eliminarLibro(boton);
                }
            });

            // Inicializar botones
            actualizarBotonesEliminar();

            // Contador de caracteres para la descripción
            document.getElementById('descripcion').addEventListener('input', function() {
                const maxLength = this.getAttribute('maxlength');
                const currentLength = this.value.length;
                document.getElementById('contador-caracteres').textContent = currentLength;
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .card {
            margin-top: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .is-invalid ~ .invalid-feedback {
            display: block !important;
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .libro-item {
            border-left: 4px solid #4e73df;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .btn-eliminar-libro.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .select2-container--bootstrap4 .select2-selection {
            min-height: 38px;
            padding: 4px 8px;
        }
        input[type="date"] {
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        input[type="date"]:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        textarea {
            resize: none;
            min-height: 100px;
        }
        @keyframes fadeOutDisplay {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                display: none;
            }
        }

        .fade-out-display {
            animation: fadeOutDisplay 1s ease-in-out forwards;
            animation-delay: 4s
        }
    </style>
@endpush