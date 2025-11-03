<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><b>Prestamos registrados</b></h3>
                <div class="card-tools">
                    <a href="javascript:void(0)" onclick="GoTo('{{ route('admin.prestamo.create') }}')" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        <b>Crear Nuevo</b>
                    </a>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="display: block;">
                <form action="" method="GET" class="mb-3 d-flex"
                    style="max-width: 400px;">
                    <input type="text" name="buscar" class="form-control me-2"
                        placeholder="Buscar por nombre" value="{{ $buscar ?? '' }}">
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
                        @if($data->isEmpty())
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
                                <td>x</td> 
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
