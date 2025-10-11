@extends('adminlte::page')

@section('title', 'Crud Libreria')

@section('title', 'Crud Libreria')

@section('content_header')
    <h1>
        {{ __('Usuarios') }} </h1>
@stop

@section('js')
<script>
    function showSuccessAlert(message){
        const container = document.querySelector('.col-md-12') || document.body
        const existing = container.querySelector('.alert.alert-success.alert-dismissible[data-js-success]')
        if (existing) {
            const msgEl = existing.querySelector('.js-success-message')
            if (msgEl) msgEl.textContent = message
            return
        }
        const wrapper = document.createElement('div')
        wrapper.innerHTML = `
            <div class="alert alert-success alert-dismissible" data-js-success="1">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                <span class="js-success-message">${message}</span>
            </div>
        `
        container.insertBefore(wrapper.firstElementChild, container.firstChild)
    }

    function reloadUsersTable(){
        const table = document.querySelector('#usersTable')
        if(!table) return
        fetch(window.location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser()
            const doc = parser.parseFromString(html, 'text/html')
            const newTbody = doc.querySelector('#usersTable tbody')
            const oldTbody = table.querySelector('tbody')
            if (newTbody && oldTbody) {
                oldTbody.innerHTML = newTbody.innerHTML
            }
        })
        .catch(err => console.error('Error al recargar la tabla:', err))
    }

    const createUserForm = document.querySelector('#createUserForm')
    if (createUserForm){
        createUserForm.addEventListener('submit', (e) => {
            e.preventDefault()
            const formData = new FormData(createUserForm)
            fetch(createUserForm.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: formData
            }).then(async res => {
                if (!res.ok){
                    if (res.status === 422){
                        const data = await res.json()
                        console.error('Errores de validación:', data)
                    }
                    throw new Error('Error al crear el usuario')
                }
                return res.json()
            }).then(data => {
                if (data.success){
                    const $modal = $(createUserForm).closest('.modal')
                    $modal.modal('hide')
                    showSuccessAlert(data.message || 'El usuario se creó correctamente.')
                    reloadUsersTable()
                    createUserForm.reset()
                }
            }).catch(err => { console.error(err) })
        })
    }

    // Editar usuario via AJAX
    document.addEventListener('submit', (e) => {
        const form = e.target
        if (form.matches('.editUserForm')){
            e.preventDefault()
            const formData = new FormData(form)
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            }).then(async res => {
                if (!res.ok){
                    if (res.status === 422){
                        const data = await res.json()
                        console.error('Errores de validación:', data)
                    }
                    throw new Error('Error al actualizar el usuario')
                }
                return res.json()
            }).then(data => {
                if (data.success){
                    const $modal = $(form).closest('.modal')
                    $modal.modal('hide')
                    showSuccessAlert(data.message || 'El usuario se actualizó correctamente.')
                    reloadUsersTable()
                }
            }).catch(err => console.error(err))
        }

        // Cambiar contraseña via AJAX
        if (form.matches('.passwordForm')){
            e.preventDefault()
            const formData = new FormData(form)
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            }).then(async res => {
                if (!res.ok){
                    if (res.status === 422){
                        const data = await res.json()
                        console.error('Errores de validación:', data)
                    }
                    throw new Error('Error al actualizar la contraseña')
                }
                return res.json()
            }).then(data => {
                if (data.success){
                    const $modal = $(form).closest('.modal')
                    $modal.modal('hide')
                    showSuccessAlert(data.message || 'La contraseña se actualizó correctamente.')
                    form.reset()
                }
            }).catch(err => console.error(err))
        }
    })
</script>
@endsection

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
                    <div class="card-tools">
                        <a href="#" data-toggle="modal" data-target="#createUserModal" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            <b>Crear Nuevo</b>
                        </a>
                    </div>

                    <!-- /.card-tools -->
                </div>
                <div class="card-body"  style="display: block;">
                    <table id="usersTable" class="table table-bordered table-striped table-hover table-sm" border="1">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                            <tr>
                                <td style="text-align: center;">{{ $usuario->id }}</td>
                                <td style="text-align: center;">{{ $usuario->name }}</td>
                                <td style="text-align: center;">{{ $usuario->email }}</td>
                                <td style="text-align: center;">
                                    <a href="#editUserModal{{ $usuario->id }}" data-toggle="modal" class="btn btn-warning" title="Editar">
                                        <i class="fas fa-edit text-white"></i>
                                    </a>
                                    @include('admin.libros.usuarios.components.editModal', ['usuario' => $usuario])

                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#passwordUserModal{{ $usuario->id }}" title="Cambiar Contraseña">
                                        <i class="fas fa-key me-2 text-white"></i>
                                    </button>
                                    @include('admin.libros.usuarios.components.passwordModal', ['usuario' => $usuario])
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                    @include('admin.libros.usuarios.components.createModal')

                </div>

            </div>
        </div>
    </div>
</div>

@stop
