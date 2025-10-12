    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Libros registrados</b></h3>
                    <div class="card-tools">
                        <a href="javascript:void(0)" onclick="GoTo('{{ route('admin.libros.create') }}')" class="btn btn-primary">
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
                                        
                                        <a href="javascript:void(0)" onclick="GoTo('{{ route('admin.libros.edit', $libro->id) }}')" class="btn btn-warning" title="Editar">
                                            <i class="fas fa-edit text-white"></i>
                                        </a>

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
                    @include('admin.libros.components.createModal')
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
