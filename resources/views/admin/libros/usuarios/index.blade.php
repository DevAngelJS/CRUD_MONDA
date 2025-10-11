@extends('adminlte::page')

@section('title', 'Crud Libreria')

@section('title', 'Crud Libreria')

@section('content_header')
    <h1>
        {{ __('Usuarios') }} </h1>
@stop

@section('content')
<div class="container mt-4">

    <div class="row">
        <div class="col-md-12">
            @session('success')
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                    {{ session('success') }}
                </div>
            @endsession

            <!-- /.card -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Usuarios</b></h3>


                    <!-- /.card-tools -->
                </div>
                <div class="card-body"  style="display: block;">
                    <table class="table table-bordered table-striped table-hover table-sm" border="1">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;">{{Auth::user()->id}}</td>
                                <td style="text-align: center;">{{Auth::user()->name}}</td>
                                <td style="text-align: center;">{{Auth::user()->email}}</td>
                                <td style="text-align: center;">
                                    <a href="{{ url('/admin/usuarios/' . Auth::user()->id. '/edit') }}"
                                            class="btn btn-warning"><i class="fas fa-edit text-white"
                                                title="Editar"></i></a>



                                    <a href="{{ url('/admin/contraseña/' . Auth::user()->id. '/edit' )}}" class="btn btn-info">
                                        <i class="fas fa-key me-2 text-white" title="Cambiar Contraseña"></i>
                                    </a>
                                    {{-- <a href="{{ route('admin.libros.contraseña.edit') }}" class="btn btn-info">
                                        <i class="fas fa-key me-2 text-white" title="Cambiar Contraseña"></i>
                                    </a> --}}


                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>

            </div>
        </div>
    </div>
</div>

@stop
