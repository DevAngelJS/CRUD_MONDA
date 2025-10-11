<!-- MODAL DE EDITAR -->
<div class="modal fade" id="showModal{{ $libro->id }}" tabindex="-1"
    role="dialog" aria-labelledby="viewModalLabel{{ $libro->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="viewModalLabel{{ $libro->id }}">
                    Editar libro</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm_{{ $libro->id }}" class="editForm" action="{{ url('admin/libros/' . $libro->id) }}" method="POST">
                <div class="modal-body">
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
                                    <input type="text" class="form-control" id="titulo_{{ $libro->id }}" name="titulo"
                                        placeholder="Ingrese el título del libro" value="{{ $libro->titulo }}">
                                </div>
                                @error('titulo')
                                    <div class="alert text-danger p-0 m-0">
                                        <b>{{ 'Este campo es obligatorio.' }}</b>
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
                                    <input type="text" class="form-control" id="autor_{{ $libro->id }}" name="autor"
                                        placeholder="Ingrese el autor del libro" value="{{ $libro->autor }}">
                                </div>
                                @error('autor')
                                    <div class="alert text-danger p-0 m-0">
                                        <b>{{ 'Este campo es obligatorio.' }}</b>
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
                                    <input type="date" class="form-control" id="año_publicacion_{{ $libro->id }}"
                                        name="año_publicacion" placeholder="Ingrese el año de publicación del libro"
                                        value="{{ $libro->año_publicacion }}">
                                </div>
                                @error('año_publicacion')
                                    <div class="alert text-danger p-0 m-0">
                                        <b>{{ 'Este campo es obligatorio.' }}</b>
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
                                    <input type="text" class="form-control" id="genero_{{ $libro->id }}" name="genero"
                                        placeholder="Ingrese el genero del libro" value="{{ $libro->genero }}">
                                </div>
                                @error('genero')
                                    <div class="alert text-danger p-0 m-0">
                                        <b>{{ 'Este campo es obligatorio.' }}</b>
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
                                        <option value="" disabled selected>Seleccione un idioma</option>
                                        <option value="Español"
                                            {{ old('idioma', $libro->idioma) == 'Español' ? 'selected' : '' }}>
                                            Español</option>
                                        <option value="Inglés"
                                            {{ old('idioma', $libro->idioma) == 'Inglés' ? 'selected' : '' }}>
                                            Inglés</option>
                                        <option value="Francés"
                                            {{ old('idioma', $libro->idioma) == 'Francés' ? 'selected' : '' }}>
                                            Francés</option>
                                        <option value="Alemán"
                                            {{ old('idioma', $libro->idioma) == 'Alemán' ? 'selected' : '' }}>
                                            Alemán</option>
                                        <option value="Italiano"
                                            {{ old('idioma', $libro->idioma) == 'Italiano' ? 'selected' : '' }}>
                                            Italiano</option>
                                        <option value="Portugués"
                                            {{ old('idioma', $libro->idioma) == 'Portugués' ? 'selected' : '' }}>
                                            Portugués</option>
                                        <option value="Chino"
                                            {{ old('idioma', $libro->idioma) == 'Chino' ? 'selected' : '' }}>Chino
                                        </option>
                                        <option value="Japonés"
                                            {{ old('idioma', $libro->idioma) == 'Japonés' ? 'selected' : '' }}>
                                            Japonés</option>
                                        <option value="Ruso"
                                            {{ old('idioma', $libro->idioma) == 'Ruso' ? 'selected' : '' }}>Ruso
                                        </option>
                                        <option value="Árabe"
                                            {{ old('idioma', $libro->idioma) == 'Árabe' ? 'selected' : '' }}>Árabe
                                        </option>
                                    </select>
                                </div>
                                @error('idioma')
                                    <div class="alert text-danger p-0 m-0">
                                        <b>{{ 'Este campo es obligatorio.' }}</b>
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
                                    <input type="number" class="form-control" id="cantidad_stock_{{ $libro->id }}"
                                        name="cantidad_stock" placeholder="Ingrese la cantidad en stock del libro"
                                        value="{{ $libro->cantidad_stock }}">
                                </div>
                                @error('cantidad_stock')
                                    <div class="alert text-danger p-0 m-0">
                                        <b>{{ 'Este campo es obligatorio.' }}</b>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group" style="text-align: right;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>