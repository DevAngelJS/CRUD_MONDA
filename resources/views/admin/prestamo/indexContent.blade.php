<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><b>Prestamos registrados</b></h3>
                <div class="card-tools">
                    <a href="javascript:void(0)" onclick="GoTo('{{ route('admin.prestamo.create') }}')"
                        class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        <b>Crear Nuevo</b>
                    </a>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="display: block;">
                <form action="" method="GET" class="mb-3 d-flex" style="max-width: 400px;">
                    <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por nombre"
                        value="{{ $buscar ?? '' }}">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <table id="example1" class="table table-bordered table-striped table-hover table-sm" border="1">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cantidad de Libros</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de fin</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->isEmpty())
                            <tr>
                                <td colspan="9" style="text-align: center;">No se encontraron prestamos.</td>
                            </tr>
                        @endif
                        @foreach ($data as $persona)
                            <tr>
                                <td>{{ $persona->name }}</td>
                                <td>{{ $persona->cantidad }}</td>
                                <td>{{ $persona->fecha_inicio }}</td>
                                <td>{{ $persona->fecha_fin }}</td>
                                <td>{{ $persona->descripcion }}</td>
                                <td style="text-align: center;">
                                    @if ($persona->estatus == 1)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#viewModal{{ $persona->id }}" data-toggle="modal" class="btn btn-info"
                                        title="Ver detalles"><i class="fas fa-eye"></i></a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="viewModal{{ $persona->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="viewModalLabel{{ $persona->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h5 class="modal-title" id="viewModalLabel{{ $persona->id }}">
                                                        Detalles del préstamo</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><b>Nombre:</b> {{ $persona->name }}</p>
                                                    <p><b>Cantidad:</b> {{ $persona->cantidad }}</p>
                                                    <p><b>Fecha de inicio:</b> {{ $persona->fecha_inicio }}</p>
                                                    <p><b>Fecha de fin:</b> {{ $persona->fecha_fin }}</p>
                                                    <p><b>Descripción:</b> {{ $persona->descripcion }}</p>
                                                    <p><b>Estado:</b>
                                                        @if ($persona->estatus == 1)
                                                            En préstamo
                                                        @else
                                                            Devuelto
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

                                    <a href="javascript:void(0)"
                                        onclick="GoTo('{{ route('admin.prestamo.edit', $persona->id) }}')"
                                        class="btn btn-warning" title="Editar">
                                        <i class="fas fa-edit text-white"></i>
                                    </a>

                                    <!-- Botón que abre el modal -->
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#confirmarEliminar{{ $persona->id }}" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal de confirmación -->
                                    <div class="modal fade" id="confirmarEliminar{{ $persona->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modalLabel{{ $persona->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel{{ $persona->id }}">
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
                                                    <form action="{{ url('admin/prestamo/' . $persona->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
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
                    {{ $data->links() }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
