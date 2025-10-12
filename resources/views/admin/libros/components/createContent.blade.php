    <div class="row">
        <div class="col-md-12 m-auto">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Llenar los campos del formulario</b></h3>

                    <div class="card-tools">
                        <a href="javascript:void(0)" class="btn btn-tool" onclick="GoTo('{{ url('admin/libros') }}')">
                            <i class="fas fa-arrow-left"></i>
                            <b>Volver</b>
                        </a>
                    </div>
                </div>
                <div class="card-body" style="display: block;">
                    <form id="createForm" action="{{ route('admin.libros.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="titulo">Título</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text inline-block"><i class="fas fa-tag"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="titulo" name="titulo"
                                            placeholder="Ingrese el título del libro">
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
                                            <span class="input-group-text inline-block"><i class="fas fa-pen"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="autor" name="autor"
                                            placeholder="Ingrese el autor del libro">
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
                                            name="año_publicacion" placeholder="Ingrese el año de publicación del libro">
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
                                            <span class="input-group-text inline-block"><i class="fas fa-book"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="genero" name="genero"
                                            placeholder="Ingrese el genero del libro">
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
                                            <span class="input-group-text inline-block"><i class="fas fa-box"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="cantidad_stock" name="cantidad_stock"
                                            placeholder="Ingrese la cantidad en stock del libro">
                                    </div>
                                    @error('cantidad_stock')
                                        <div class="alert text-danger p-0 m-0">
                                            <b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <a href="javascript:void(0)" onclick="GoTo('{{ url('admin/libros') }}')" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
