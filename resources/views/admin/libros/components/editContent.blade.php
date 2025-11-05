    <div class="row">
        <div class="col-md-12 m-auto">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><b>Editar libro</b></h3>
                    <div class="card-tools">
                        <a href="javascript:void(0)" class="btn btn-tool" onclick="GoTo('{{ url('admin/libros') }}')">
                            <i class="fas fa-arrow-left"></i>
                            <b>Volver</b>
                        </a>
                    </div>
                </div>
                <div class="card-body" style="display: block;">
                    <form class="editForm" action="{{ url('admin/libros/' . $libro->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="titulo_{{ $libro->id }}">Título</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text inline-block"><i
                                                    class="fas fa-tag"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="titulo_{{ $libro->id }}"
                                            name="titulo" placeholder="Ingrese el título del libro"
                                            value="{{ $libro->titulo }}">
                                    </div>
                                    @error('titulo')
                                        <div class="alert text-danger p-0 m-0"><b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="autor_{{ $libro->id }}">Autor</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text inline-block"><i
                                                    class="fas fa-pen"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="autor_{{ $libro->id }}"
                                            name="autor" placeholder="Ingrese el autor del libro"
                                            value="{{ $libro->autor }}">
                                    </div>
                                    @error('autor')
                                        <div class="alert text-danger p-0 m-0"><b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="año_publicacion_{{ $libro->id }}">Año de publicación</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text inline-block"><i
                                                    class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="date" class="form-control"
                                            id="año_publicacion_{{ $libro->id }}" name="año_publicacion"
                                            value="{{ $libro->año_publicacion }}">
                                    </div>
                                    @error('año_publicacion')
                                        <div class="alert text-danger p-0 m-0"><b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="genero_{{ $libro->id }}">Género</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text inline-block"><i
                                                    class="fas fa-book"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="genero_{{ $libro->id }}"
                                            name="genero" placeholder="Ingrese el genero del libro"
                                            value="{{ $libro->genero }}">
                                    </div>
                                    @error('genero')
                                        <div class="alert text-danger p-0 m-0"><b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="idioma_{{ $libro->id }}">Idioma</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text inline-block"><i
                                                    class="fas fa-language"></i></span>
                                        </div>
                                        <select name="idioma" id="idioma_{{ $libro->id }}" class="form-control">
                                            <option value="" disabled>Seleccione un idioma</option>
                                            @foreach (['Español', 'Inglés', 'Francés', 'Alemán', 'Italiano', 'Portugués', 'Chino', 'Japonés', 'Ruso', 'Árabe'] as $opt)
                                                <option value="{{ $opt }}"
                                                    {{ old('idioma', $libro->idioma) == $opt ? 'selected' : '' }}>
                                                    {{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('idioma')
                                        <div class="alert text-danger p-0 m-0"><b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_stock_{{ $libro->id }}">Cantidad en Stock</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text inline-block"><i
                                                    class="fas fa-box"></i></span>
                                        </div>
                                        <input type="number" class="form-control"
                                            id="cantidad_stock_{{ $libro->id }}" name="cantidad_stock"
                                            placeholder="Ingrese la cantidad en stock del libro"
                                            value="{{ $libro->cantidad_stock }}">
                                    </div>
                                    @error('cantidad_stock')
                                        <div class="alert text-danger p-0 m-0"><b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <a href="javascript:void(0)" onclick="GoTo('{{ url('admin/libros') }}')"
                                class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-warning text-white">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.routeLibrosIndex = "{{ route('admin.libros.index') }}";
    </script>
