<!-- MODAL DE CREAR LIBRO -->
<div class="modal fade" id="createModal" tabindex="-1"
    role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="createModalLabel">
                    Crear libro</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createForm" action="{{ route('admin.libros.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="titulo">Título</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text inline-block"><i
                                                class="fas fa-tag"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="titulo" name="titulo"
                                        placeholder="Ingrese el título del libro" value="{{ old('titulo') }}">
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
                                <label for="autor">Autor</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text inline-block"><i
                                                class="fas fa-pen"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="autor" name="autor"
                                        placeholder="Ingrese el autor del libro" value="{{ old('autor') }}">
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
                                <label for="año_publicacion">Año de publicación</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text inline-block"><i
                                                class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="date" class="form-control" id="año_publicacion"
                                        name="año_publicacion" placeholder="Ingrese el año de publicación del libro"
                                        value="{{ old('año_publicacion') }}">
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
                                <label for="genero">Genero</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text inline-block"><i
                                                class="fas fa-book"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="genero" name="genero"
                                        placeholder="Ingrese el genero del libro" value="{{ old('genero') }}">
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
                                <label for="idioma">Idioma</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text inline-block"><i
                                                class="fas fa-language"></i></span>
                                    </div>
                                    <select name="idioma" id="idioma" class="form-control">
                                        <option value="" disabled selected>Seleccione un idioma</option>
                                        <option value="Español">Español</option>
                                        <option value="Inglés">Inglés</option>
                                        <option value="Francés">Francés</option>
                                        <option value="Alemán">Alemán</option>
                                        <option value="Italiano">Italiano</option>
                                        <option value="Portugués">Portugués</option>
                                        <option value="Chino">Chino</option>
                                        <option value="Japonés">Japonés</option>
                                        <option value="Ruso">Ruso</option>
                                        <option value="Árabe">Árabe</option>
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
                                <label for="cantidad_stock">Cantidad en Stock</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text inline-block"><i
                                                class="fas fa-box"></i></span>
                                    </div>
                                    <input type="number" class="form-control" id="cantidad_stock"
                                        name="cantidad_stock" placeholder="Ingrese la cantidad en stock del libro"
                                        value="{{ old('cantidad_stock') }}">
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
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>