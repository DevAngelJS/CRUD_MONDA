@extends('adminlte::page')

@section('title', 'Crud Libreria')

@section('content_header')
    <h1>
        {{ __('Libreria') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @session('success')
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                    {{ session('success') }}
                </div>
            @endsession
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Libros registrados</b></h3>

                    <div class="card-tools">
                        <a class="btn btn-primary" href=" {{ url('admin/libros/create') }}" class="btn btn-tool">
                            <i class="fas fa-plus"></i>
                            <b>Crear Nuevo</b>
                        </a>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                    <form action="{{ route('admin.libros.index') }}" method="GET" class="mb-3 d-flex"
                        style="max-width: 400px;">
                        <input type="text" name="buscar" class="form-control me-2"
                            placeholder="Buscar por título, autor o género" value="{{ $buscar ?? '' }}">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>

                    <table id="example1" class="table table-bordered table-striped table-hover table-sm" border="1">
                        <thead>
                            <tr>
                                <th>Titulo</th>
                                <th>Autor</th>
                                <th>Año de publicación</th>
                                <th>Genero</th>
                                <th>Idioma</th>
                                <th>Cantidad en Stock</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($libros->isEmpty())
                                <tr>
                                    <td colspan="9" style="text-align: center;">No se encontraron libros.</td>
                                </tr>
                            @endif

                            @foreach ($libros as $libro)
                                <tr>
                                    <td>{{ $libro->titulo }}</td>
                                    <td>{{ $libro->autor }}</td>
                                    <td style="text-align: center;">{{ $libro->año_publicacion }}</td>
                                    <td>{{ $libro->genero }}</td>
                                    <td>{{ $libro->idioma }}</td>
                                    <td style="text-align: center;">{{ $libro->cantidad_stock }}</td>
                                    <td style="text-align: center;">
                                        @if ($libro->estatus == 1)
                                            <span class="badge badge-success">Disponible</span>
                                        @else
                                            <span class="badge badge-danger">No disponible</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#viewModal{{ $libro->id }}" data-toggle="modal" class="btn btn-info"
                                            title="Ver detalles"><i class="fas fa-eye"></i></a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="viewModal{{ $libro->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="viewModalLabel{{ $libro->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h5 class="modal-title" id="viewModalLabel{{ $libro->id }}">
                                                            Detalles del libro</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><b>Título:</b> {{ $libro->titulo }}</p>
                                                        <p><b>Autor:</b> {{ $libro->autor }}</p>
                                                        <p><b>Año de publicación:</b> {{ $libro->año_publicacion }}</p>
                                                        <p><b>Género:</b> {{ $libro->genero }}</p>
                                                        <p><b>Idioma:</b> {{ $libro->idioma }}</p>
                                                        <p><b>Cantidad en Stock:</b> {{ $libro->cantidad_stock }}</p>
                                                        <p><b>Estado:</b>
                                                            @if ($libro->estatus == 1)
                                                                Disponible
                                                            @else
                                                                No disponible
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <a href="#showModal{{ $libro->id }}" data-toggle="modal" class="btn btn-warning" title="Editar">
                                            <i class="fas fa-edit text-white"></i>
                                        </a>

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
                                                    <form id="editForm" action="{{ url('admin/libros/' . $libro->id) }}" method="POST">
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
                                        <!-- Botón que abre el modal -->
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#confirmarEliminar{{ $libro->id }}" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <!-- Modal de confirmación -->
                                        <div class="modal fade" id="confirmarEliminar{{ $libro->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modalLabel{{ $libro->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel{{ $libro->id }}">
                                                            Confirmar eliminación</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Cerrar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estás seguro de que deseas eliminar este libro?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ url('admin/libros/' . $libro->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit"
                                                                class="btn btn-danger">Eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $libros->appends(['buscar' => $buscar])->links() }}
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@stop

@section('js')
<script>


    editForm.addEventListener("submit", (e)=>{
        e.preventDefault()
        
        const formData = new FormData(editForm)

        fetch(editForm.action, {
            method: "POST",
            body: formData
        }).then(res => {
            if(!res.ok){
                throw new Error("Error al actualizar el libro")
            }
            return res.json()
        }).then(data => {
            if(data.success){
                console.log(data.message)
            }
        })

    })

</script>
@endsection