<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Préstamo</h3>
    </div>
    <form action="{{ url('admin/prestamo/' . $data->id) }}" method="POST" id="editForm" novalidate>
        @csrf
        <div class="card-body">
            <div class="row">
                <!-- Primera columna -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estudiante_id">Estudiante</label>
                        <select class="form-control select2 @error('estudiante_id') is-invalid @enderror"
                            id="estudiante_id" name="estudiante_id" required>
                            <option value="" selected disabled>Seleccione un estudiante</option>
                            @foreach ($estudiantes as $estudiante)
                                <option value="{{ $estudiante->id }}"
                                    {{ old('estudiante_id', $data->usuario_id) == $estudiante->id ? 'selected' : '' }}>
                                    {{ $estudiante->name }}</option>
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
                            <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror"
                                id="fecha_fin" name="fecha_fin" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                value="{{ $data->fecha_fin }}" placeholder="Seleccione la fecha de finalización">
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
                            <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror"
                                id="fecha_inicio" name="fecha_inicio" required min="{{ date('Y-m-d') }}"
                                value="{{ $data->fecha_inicio }}" placeholder="Seleccione la fecha de inicio">
                            @error('fecha_inicio')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                            rows="3" placeholder="Ingrese una descripción del préstamo" maxlength="100">{{ old('descripcion', $data->descripcion) }}</textarea>
                        <small class="text-muted float-right"><span
                                id="contador-caracteres">{{ strlen(old('descripcion', $data->descripcion)) }}</span>/100
                            caracteres</small>
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
                        @foreach ($detalleLibros as $i => $detalle)
                            <div class="row libro-item mb-3">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Libro</label>
                                        <select class="form-control select-libro"
                                            name="libros[{{ $i }}][libro_id]" required>
                                            <option value="" selected disabled>Seleccione un libro</option>
                                            @foreach ($libros as $libro)
                                                <option value="{{ $libro->id }}"
                                                    {{ $detalle->libro_id == $libro->id ? 'selected' : '' }}>
                                                    {{ $libro->titulo }} - {{ $libro->autor }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="number" class="form-control cantidad-libro"
                                            name="libros[{{ $i }}][cantidad]" min="1"
                                            value="{{ $detalle->cantidad }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4 d-flex align-items-center mt-3">
                                    <button type="button" class="btn btn-danger btn-eliminar-libro">
                                        <i class="fas fa-trash"></i> Quitar
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        {{-- Si no hay libros (por precaución) --}}
                        @if ($detalleLibros->isEmpty())
                            <div class="row libro-item mb-3">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Libro</label>
                                        <select class="form-control select-libro" name="libros[0][libro_id]" required>
                                            <option value="" selected disabled>Seleccione un libro</option>
                                            @foreach ($libros as $libro)
                                                <option value="{{ $libro->id }}">{{ $libro->titulo }} -
                                                    {{ $libro->autor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="number" class="form-control cantidad-libro"
                                            name="libros[0][cantidad]" min="1" value="1" required>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center mt-3">
                                    <button type="button" class="btn btn-danger btn-eliminar-libro" disabled>
                                        <i class="fas fa-trash"></i> Quitar
                                    </button>
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
            <button type="button" class="btn btn-secondary" onclick="GoTo('{{ route('admin.prestamo.index') }}')">
                <i class="fas fa-arrow-left"></i> Cancelar
            </button>
        </div>
    </form>
</div>

<script>
    window.routePrestamoIndex = "{{ route('admin.prestamo.index') }}";
</script>
