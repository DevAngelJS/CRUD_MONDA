@extends('adminlte::page')

@section('title', 'Crud Libreria')

@section('content_header')
    <h1>
        {{ __('Usuarios') }} </h1>
@stop

@section('js')
    <script>
        function showSuccessAlert(message) {
            const container = document.querySelector('.col-md-12') || document.body;
            const selector = '.alert.alert-success.alert-dismissible[data-js-success]';
            let existing = container.querySelector(selector);

            // Helper para eliminar/cerrar la alerta (usa Bootstrap/jQuery si está disponible)
            function removeAlert(alertEl) {
                if (window.jQuery) {
                    $(alertEl).alert('close');
                } else {
                    alertEl.remove();
                }
            }

            const wrapper = document.createElement('div');
            wrapper.innerHTML = `
        <div class="alert alert-success alert-dismissible" data-js-success="1">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
            <span class="js-success-message">${message}</span>
        </div>
    `;
            const alertEl = wrapper.firstElementChild;
            container.insertBefore(alertEl, container.firstChild);

            // Si el usuario cierra manualmente con el botón, cancelar el timeout
            const closeBtn = alertEl.querySelector('.close');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    if (alertEl._dismissTimeout) {
                        clearTimeout(alertEl._dismissTimeout);
                    }
                    removeAlert(alertEl);
                });
            }

            // Auto-cierre en 2 segundos
            alertEl._dismissTimeout = setTimeout(() => removeAlert(alertEl), 1000);
        }

        function reloadUsersTable() {
            const table = document.querySelector('#usersTable')
            if (!table) return
            fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
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

        // =====================================================
        // === BLOQUE PRINCIPAL ===

        $(function() {
            const $usersCard = $('#usersCard');
            const $createSection = $('#userFormSection');
            const $editSection = $('#editFormSection');
            const $passwordSection = $('#passwordFormSection');

            // Función helper para ocultar todos los formularios
            function hideAllForms() {
                $createSection.hide();
                $editSection.hide();
                $passwordSection.hide();
            }

            // Función helper para mostrar la tabla
            function showUsersTable() {
                hideAllForms();
                $usersCard.slideDown(200);
            }

            // Abrir crear
            $(document).on('click', '.btn-crear', function(e) {
                e.preventDefault();
                $usersCard.slideUp(200, function() {
                    hideAllForms();
                    $createSection.slideDown(200);
                });
            });

            // Abrir editar
            $(document).on('click', '.btn-editar', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const perfil = $(this).data('perfil') || 'estudiante';
                const name = $(this).data('name') || '';
                const email = $(this).data('email') || '';

                $('#edit_perfil').val(perfil);
                $('#edit_name').val(name);
                $('#edit_email').val(email);

                const updateUrl = "{{ route('admin.libros.usuarios.update', ['id' => ':id']) }}".replace(
                    ':id', id);
                $('#editUserForm').attr('action', updateUrl);

                $usersCard.slideUp(200, function() {
                    hideAllForms();
                    $editSection.slideDown(200);
                });
            });

            // Abrir cambiar contraseña
            $(document).on('click', '.btn-password', function(e) {
                e.preventDefault();
                const id = $(this).data('id');

                const passwordUrl = "{{ route('admin.libros.contraseña.update', ['id' => ':id']) }}"
                    .replace(':id', id);
                $('#passwordUserForm').attr('action', passwordUrl);

                $usersCard.slideUp(200, function() {
                    hideAllForms();
                    $passwordSection.slideDown(200);
                });
            });

            // Botón volver
            $(document).on('click', '.btn-volver', function(e) {
                e.preventDefault();
                e.stopPropagation();

                $createSection.slideUp(200);
                $editSection.slideUp(200);
                $passwordSection.slideUp(200);

                setTimeout(function() {
                    $usersCard.slideDown(200);
                }, 250);
            });

            // Submit crear usuario
            $(document).on('submit', '#createUserForm', function(e) {
                e.preventDefault();

                const $f = $(this);
                const action = $f.attr('action');
                const data = new FormData(this);

                fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: data
                    })
                    .then(async res => {
                        if (!res.ok) {
                            const errorData = await res.json().catch(() => null);
                            if (res.status === 422 && errorData && errorData.errors) {
                                let errorMsg = 'Errores de validación:\n';
                                Object.values(errorData.errors).forEach(errors => {
                                    errors.forEach(error => errorMsg += '- ' + error +
                                        '\n');
                                });
                                alert(errorMsg);
                            }
                            throw new Error('Error al crear usuario');
                        }
                        return res.json();
                    })
                    .then(json => {
                        if (json.success) {
                            showSuccessAlert(json.message || 'Usuario creado correctamente');
                            $f[0].reset();
                            reloadUsersTable();
                            showUsersTable();
                        }
                    })
                    .catch(err => console.error(err));
            });

            // Submit editar usuario
            $(document).on('submit', '#editUserForm', function(e) {
                e.preventDefault();

                const $f = $(this);
                const action = $f.attr('action');
                const data = new FormData(this);

                fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: data
                    })
                    .then(async res => {
                        if (!res.ok) {
                            const errorData = await res.json().catch(() => null);
                            console.error('Error:', errorData || res.statusText);
                            throw new Error('Error en la actualización');
                        }
                        return res.json();
                    })
                    .then(json => {
                        if (json.success) {
                            showSuccessAlert(json.message || 'Usuario actualizado correctamente');
                            reloadUsersTable();
                            showUsersTable();
                        }
                    })
                    .catch(err => console.error(err));
            });

            // Submit cambiar contraseña
            $(document).on('submit', '#passwordUserForm', function(e) {
                e.preventDefault();
                const $f = $(this);
                const action = $f.attr('action');
                const data = new FormData(this);

                fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: data
                }).then(async res => {
                    if (!res.ok) {
                        if (res.status === 422) {
                            const json = await res.json();
                            console.error('Validación', json);
                            alert(
                                'Error de validación. Verifica que las contraseñas coincidan y tengan al menos 6 caracteres.'
                            );
                        }
                        throw new Error('Error al actualizar contraseña');
                    }
                    return res.json();
                }).then(json => {
                    if (json.success) {
                        showSuccessAlert(json.message || 'Contraseña actualizada correctamente');
                        $f[0].reset();
                        showUsersTable();
                    }
                }).catch(err => console.error(err));
            });
        });
    </script>
@endsection

@section('content')
    <div class=" mt-4">

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
                <div id="usersCard" class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>Usuarios</b></h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-primary btn-crear">
                                <i class="fas fa-plus"></i>
                                <b>Crear Nuevo</b>
                            </a>
                        </div>

                        <!-- /.card-tools -->
                    </div>
                    <div class="card-body" style="display: block;">
                        <table id="usersTable" class="table table-bordered table-striped table-hover table-sm"
                            border="1">
                            <thead>
                                <tr>
                                    <th>Perfil</th>
                                    <th>Nombre Completo</th>
                                    <th>Email</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td style="text-align: center; text-transform:capitalize">{{ $usuario->perfil }}
                                        </td>
                                        <td style="text-align: center;">{{ $usuario->name }}</td>
                                        <td style="text-align: center;">{{ $usuario->email }}</td>
                                        <td style="text-align: center;">
                                            <!-- Botón editar: solo clases y data- -->
                                            <a href="#" class="btn btn-warning btn-editar text-white"
                                                data-id="{{ $usuario->id }}" data-name="{{ $usuario->name }}"
                                                data-email="{{ $usuario->email }}" data-perfil="{{ $usuario->perfil }}"
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Botón cambiar contraseña -->
                                            <button type="button" class="btn btn-info btn-password"
                                                data-id="{{ $usuario->id }}" title="Cambiar Contraseña">
                                                <i class="fas fa-key me-2 text-white"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $usuarios->appends(['perPage' => $perPage])->links() }}
                        </div>



                    </div>

                </div>
                <div id="userFormSection" style="display: none;">
                    @include('admin.libros.usuarios.components.createModal') <!-- tu form crear -->
                </div>

                <!-- Un único form de edición (inicialmente oculto) -->
                <div id="editFormSection" class="user-form-card" style="display:none;">
                    @include('admin.libros.usuarios.components.editModal') <!-- ver abajo: editForm sin $usuario -->
                </div>

                <!-- Un único form de cambiar contraseña (oculto) -->
                <div id="passwordFormSection" class="user-form-card" style="display:none;">
                    @include('admin.libros.usuarios.components.passwordModal') <!-- ver abajo -->
                </div>

            </div>
        </div>
    </div>

@stop
