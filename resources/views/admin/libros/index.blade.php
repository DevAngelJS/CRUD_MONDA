@extends('adminlte::page')

@section('title', 'Crud Libreria')

@section('content_header')
    <h1>
        {{ __('Libreria') }}</h1>
@stop

@section('content')
    <input type="hidden" id="FormOpen" value="0">
    <div id="content-wrapper">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                {{ session('success') }}
            </div>
        @endif
        @include('admin.libros.components.indexContent')
    </div>
    </div>
@stop

@section('js')
    <script>
        // Muestra un alert de éxito (estilo similar al session('success'))
        function showSuccessAlert(message) {
            const container = document.querySelector('.col-md-12') || document.body
            // Si ya hay un alert de éxito, actualizar el mensaje y no crear otro
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
            // Insertar al inicio del contenedor
            container.insertBefore(wrapper.firstElementChild, container.firstChild)
        }

        function reloadTable() {
            const table = document.querySelector('#example1')
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
                    const newTbody = doc.querySelector('#example1 tbody')
                    const oldTbody = table.querySelector('tbody')
                    if (newTbody && oldTbody) {
                        oldTbody.innerHTML = newTbody.innerHTML
                    }
                })
                .catch(err => console.error('Error al recargar la tabla:', err))

        }






        // --- Navegación dinámica sin spinner ---
        if (typeof Swal === 'undefined') {
            var s = document.createElement('script');
            s.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
            document.head.appendChild(s);
        }

        function injectContent(html) {
            const target = document.getElementById('content-wrapper');
            if (target) target.innerHTML = html;
        }

        function fetchAndSwap(url, onDone) {
            $.ajax({
                url: url,
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).done(function(data) {
                injectContent(data);
                history.pushState({
                    urlPath: window.location.pathname
                }, document.title, url);
                // Marcar estado de formulario según URL (create o edit)
                if (/\/admin\/libros\/create(\b|\/|\?|$)/.test(url) ||
                    /\/admin\/libros\/(\d+|[^\/]+)\/edit(\b|\/|\?|$)/.test(url)) {
                    $('#FormOpen').val(1);
                } else {
                    $('#FormOpen').val(0);
                }
                if (typeof onDone === 'function') onDone();
            }).fail(function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Error', 'No se pudo cargar el contenido.', 'error');
                } else {
                    alert('No se pudo cargar el contenido.');
                }
            });
        }

        function GoTo(url) {
            var formOpenVal = $('#FormOpen').val();
            if (formOpenVal == 1 && typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¿Quiere salir de esta pantalla?',
                    text: 'Esta acción causará que se pierdan los datos del formulario!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, salir!',
                    cancelButtonText: 'No, cancelar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetchAndSwap(url);
                        $('#FormOpen').val(0);
                    }
                });
            } else {
                fetchAndSwap(url);
            }
        }

        window.addEventListener('popstate', function(event) {
            if (event.state && event.state.urlPath) {
                // Recargar el contenido para la URL actual
                $.ajax({
                    url: location.pathname + location.search,
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).done(function(data) {
                    injectContent(data);
                });
            }
        });

        $(document).on('submit', '.createForm, .editForm', function(e) {
            e.preventDefault();

            const $form = $(this);
            const formData = new FormData(this);
            const csrf = $('meta[name="csrf-token"]').attr('content');
            const url = $form.attr('action');
            const method = $form.find('input[name="_method"]').val() || 'POST';

            $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    }
                })
                .done(function(resp) {
                    if (resp && resp.status === 'success') {
                        if (typeof fetchAndSwap === 'function') {
                            fetchAndSwap(window.routeLibrosIndex, function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: resp.message
                                });
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: resp.message
                            }).then(() => window.location.href = window.routeLibrosIndex);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: resp?.message || 'Error desconocido.'
                        });
                    }
                })
                .fail(function(xhr) {
                    let msg = 'Error al procesar la solicitud.';
                    if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg
                    });
                });
        });
    </script>
@endsection
