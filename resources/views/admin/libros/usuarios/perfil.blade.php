@extends('adminlte::page')

@section('title', 'Mi usuario')

@section('content_header')
    <h1>Mi perfil</h1>
    <p class="text-muted">Bienvenido, <strong>{{ auth()->user()->name }}</strong></p>
@stop

@section('js')
    <script>
        function showSuccessAlert(message) {
            const container = document.querySelector('.col-md-12') || document.querySelector('.col-md-10') || document.body;
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

            const closeBtn = alertEl.querySelector('.close');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    if (alertEl._dismissTimeout) clearTimeout(alertEl._dismissTimeout);
                    if (window.jQuery) {
                        $(alertEl).alert('close');
                    } else {
                        alertEl.remove();
                    }
                });
            }

            alertEl._dismissTimeout = setTimeout(() => {
                if (window.jQuery) {
                    $(alertEl).alert('close');
                } else {
                    alertEl.remove();
                }
            }, 3000);
        }

        $(function() {
            const $profileCard = $('#profileCard');
            const $editSection = $('#editProfileSection');
            const $passwordSection = $('#passwordProfileSection');

            function hideAllForms() {
                $editSection.hide();
                $passwordSection.hide();
            }

            function showProfileCard() {
                hideAllForms();
                $profileCard.slideDown(200);
            }

            // Abrir editar perfil
            $(document).on('click', '.btn-editar-perfil', function(e) {
                e.preventDefault();
                const user = @json(auth()->user());

                // Poblar los campos del formulario reutilizable
                $('#edit_perfil').val(user.perfil || 'estudiante');
                $('#edit_name').val(user.name);
                $('#edit_email').val(user.email);

                const updateUrl = "{{ route('admin.libros.usuarios.update', ['id' => ':id']) }}".replace(
                    ':id', user.id);
                $('#editUserForm').attr('action', updateUrl);

                $profileCard.slideUp(200, function() {
                    hideAllForms();
                    $editSection.slideDown(200);
                });
            });

            // Abrir cambiar contraseña
            $(document).on('click', '.btn-cambiar-password', function(e) {
                e.preventDefault();
                const user = @json(auth()->user());

                const passwordUrl = "{{ route('admin.libros.contraseña.update', ['id' => ':id']) }}"
                    .replace(':id', user.id);
                $('#passwordUserForm').attr('action', passwordUrl);

                $profileCard.slideUp(200, function() {
                    hideAllForms();
                    $passwordSection.slideDown(200);
                });
            });

            // Botón volver - reutilizar el evento existente
            $(document).on('click', '.btn-volver', function(e) {
                e.preventDefault();
                e.stopPropagation();

                $editSection.slideUp(200);
                $passwordSection.slideUp(200);

                setTimeout(function() {
                    $profileCard.slideDown(200);
                }, 250);
            });

            // Submit editar perfil - reutilizar el evento existente de #editUserForm
            $(document).on('submit', '#editUserForm', function(e) {
                // Solo interceptar si estamos en la página de perfil
                if (!$('#profileCard').length) return;

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
                            throw new Error('Error en la actualización');
                        }
                        return res.json();
                    })
                    .then(json => {
                        if (json.success) {
                            showSuccessAlert(json.message || 'Perfil actualizado correctamente');
                            // Recargar la página para actualizar los datos en el card
                            setTimeout(() => window.location.reload(), 1500);
                        }
                    })
                    .catch(err => console.error(err));
            });

            // Submit cambiar contraseña - reutilizar el evento existente de #passwordUserForm
            $(document).on('submit', '#passwordUserForm', function(e) {
                // Solo interceptar si estamos en la página de perfil
                if (!$('#profileCard').length) return;

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
                        const json = await res.json();

                        if (!res.ok) {
                            if (res.status === 422) {
                                if (json.errors) {
                                    let errorMsg = 'Errores encontrados:\n\n';
                                    Object.keys(json.errors).forEach(field => {
                                        errorMsg += `Campo: ${field}\n`;
                                        json.errors[field].forEach(error => {
                                            errorMsg += `  ✗ ${error}\n`;
                                        });
                                        errorMsg += '\n';
                                    });
                                    alert(errorMsg);
                                } else if (json.message) {
                                    alert('❌ ' + json.message);
                                }
                            }
                            throw new Error(json.message || 'Error al actualizar contraseña');
                        }

                        return json;
                    })
                    .then(json => {
                        if (json.success) {
                            showSuccessAlert(json.message || 'Contraseña actualizada correctamente');
                            $f[0].reset();
                            showProfileCard();
                        }
                    })
                    .catch(err => console.error(err));
            });
        });
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tarjeta principal del perfil --}}
            <div id="profileCard" class="card card-primary">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="card-title"><b>Datos de la cuenta</b></h3>
                    </div>
                    <div class="card-tools d-flex justify-content-end" style="width: 88%;">
                        <a href="{{ route('admin.libros.usuarios.index') }}" class="btn btn-tool" title="Volver a usuarios">
                            <i class="fas fa-arrow-left"></i>
                            <b>Volver</b>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        {{-- Columna izquierda: resumen --}}
                        <div class="col-md-4 text-center border-right">
                            @php
                                $user = auth()->user();
                                $initials = collect(explode(' ', trim($user->name)))
                                    ->map(fn($s) => strtoupper(substr($s, 0, 1)))
                                    ->take(2)
                                    ->join('');
                            @endphp

                            <div class="mb-3">
                                <div
                                    style="width:120px;height:120px;border-radius:50%;background:#007bff;display:inline-flex;align-items:center;justify-content:center;font-size:34px;color:white;font-weight:bold;">
                                    {{ $initials }}
                                </div>
                            </div>

                            <h5 class="mb-0">{{ $user->name }}</h5>
                            <small class="text-muted d-block mb-1">{{ $user->email }}</small>
                            <span class="badge badge-info mb-3">{{ ucfirst($user->perfil ?? 'N/A') }}</span>

                            <p class="mb-1"><strong>Cuenta creada:</strong><br>
                                <small class="text-muted">{{ $user->created_at?->format('d/m/Y H:i') ?? '—' }}</small>
                            </p>
                        </div>

                        {{-- Columna derecha: acciones --}}
                        <div class="col-md-8">
                            <h5 class="mb-3"><i class="fas fa-cog"></i> Opciones de cuenta</h5>

                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action btn-editar-perfil">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1"><i class="fas fa-user-edit text-warning"></i> Editar
                                                información personal</h6>
                                            <p class="mb-0 text-muted small">Actualiza tu nombre, email y perfil</p>
                                        </div>
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </a>

                                <a href="#" class="list-group-item list-group-item-action btn-cambiar-password">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1"><i class="fas fa-key text-info"></i> Cambiar contraseña</h6>
                                            <p class="mb-0 text-muted small">Modifica tu contraseña de acceso</p>
                                        </div>
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="alert alert-info mt-4 mb-0">
                                <h6><i class="icon fas fa-info-circle"></i> Información</h6>
                                <small>Mantén tu información actualizada para mejorar la seguridad de tu cuenta.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reutilizar el formulario de edición existente --}}
            <div id="editProfileSection" style="display: none;">
                @include('admin.libros.usuarios.components.editModal')
            </div>

            {{-- Reutilizar el formulario de cambiar contraseña existente --}}
            <div id="passwordProfileSection" style="display: none;">
                @include('admin.libros.usuarios.components.passwordModal')
            </div>

        </div>
    </div>
@endsection
