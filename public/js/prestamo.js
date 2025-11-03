// Función para ocultar mensajes después de un tiempo
function ocultarMensajes() {
    // Ocultar mensajes de éxito después de 5 segundos
    const mensajesExito = document.querySelectorAll('.alert-success');
    mensajesExito.forEach(mensaje => {
        setTimeout(() => {
            mensaje.style.transition = 'opacity 0.5s';
            mensaje.style.opacity = '0';
            setTimeout(() => mensaje.remove(), 500);
        }, 5000);
    });

    // Ocultar mensajes de error después de 5 segundos
    const mensajesError = document.querySelectorAll('.alert-danger, .invalid-feedback');
    mensajesError.forEach(mensaje => {
        setTimeout(() => {
            mensaje.style.transition = 'opacity 0.5s';
            mensaje.style.opacity = '0';
            setTimeout(() => mensaje.remove(), 500);
        }, 5000);
    });
}



document.addEventListener('DOMContentLoaded', function() {
    // Ocultar mensajes al cargar la página
    ocultarMensajes();
    
    // Configurar validación en tiempo real
    const form = document.getElementById('form-prestamo');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
                const errorMsg = this.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                    errorMsg.style.display = 'none';
                }
            }
        });
        
        // Para los campos de fecha, validar cuando pierden el foco
        if (input.type === 'date') {
            input.addEventListener('change', function() {
                if (this.value) {
                    this.classList.remove('is-invalid');
                    const errorMsg = this.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                        errorMsg.style.display = 'none';
                    }
                }
            });
        }
    });

    let contadorLibros = 0;
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('cantidad-libro')) {
            if (e.target.value < 1) {
                e.target.value = 1;
            }
        }
    });

    // Agregar nuevo libro
    document.getElementById('agregar-libro').addEventListener('click', function() {
        contadorLibros++;
        
        const nuevoLibro = `
            <div class="row libro-item mb-3">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Libro</label>
                        <select class="form-control select-libro" name="libros[${contadorLibros}][libro_id]" required>
                            <option value="">Seleccione un libro</option>
                            @foreach($libros as $libro)
                                <option value="{{ $libro->id }}">{{ $libro->titulo }} - {{ $libro->autor }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback d-none" id="libro-${contadorLibros}-error"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Cantidad</label>
                        <input type="number" class="form-control cantidad-libro" 
                                name="libros[${contadorLibros}][cantidad]" min="1" value="1" required>
                        <div class="invalid-feedback d-none" id="cantidad-${contadorLibros}-error"></div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center mt-3">
                    <button type="button" class="btn btn-danger btn-eliminar-libro" disabled>
                        <i class="fas fa-trash"></i> Quitar
                    </button>
                </div>
            </div>
        `;
        
        document.getElementById('libros-container').insertAdjacentHTML('beforeend', nuevoLibro);
        actualizarBotonesEliminar();
    });

    // Eliminar libro
    function eliminarLibro(boton) {
        const items = document.querySelectorAll('.libro-item');
        if (items.length > 1) {
            boton.closest('.libro-item').remove();
            actualizarBotonesEliminar();
        }
    }

    // Actualizar estado de botones eliminar
    function actualizarBotonesEliminar() {
        const botones = document.querySelectorAll('.btn-eliminar-libro');
        const items = document.querySelectorAll('.libro-item');
        
        botones.forEach(boton => {
            if (items.length === 1) {
                boton.disabled = true;
                boton.classList.add('disabled');
            } else {
                boton.disabled = false;
                boton.classList.remove('disabled');
            }
        });
    }

    // Delegación de eventos para botones eliminar
    document.getElementById('libros-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-eliminar-libro') || 
            e.target.closest('.btn-eliminar-libro')) {
            const boton = e.target.classList.contains('btn-eliminar-libro') ? 
                            e.target : e.target.closest('.btn-eliminar-libro');
            eliminarLibro(boton);
        }
    });

    // Inicializar botones
    actualizarBotonesEliminar();

    // Contador de caracteres para la descripción
    document.getElementById('descripcion').addEventListener('input', function() {
        const maxLength = this.getAttribute('maxlength');
        const currentLength = this.value.length;
        document.getElementById('contador-caracteres').textContent = currentLength;
    });
});

//PARTE DE AJAX



// Muestra un alert de éxito (estilo similar al session('success'))
function showSuccessAlert(message){
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

function reloadTable(){
    const table = document.querySelector('#example1')
    if(!table) return

    fetch(window.location.href, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
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


$(document).on('submit', '.editForm', function(e){
    e.preventDefault();
    var $form = $(this);
    var formData = new FormData(this);
    var csrf = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: $form.attr('action'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
    }).done(function(resp){
        fetchAndSwap('/admin/prestamo', function(){
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'success', title: 'Éxito', text: (resp && resp.message) ? resp.message : 'Prestamo actualizado correctamente.' });
            }
        });
    }).fail(function(xhr){
        let msg = 'Error al actualizar el prestamo.';
        if (xhr && xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'error', title: 'Error', text: msg });
        } else {
            alert(msg);
        }
    });
});


// --- Navegación dinámica sin spinner ---
if (typeof Swal === 'undefined') {
    var s = document.createElement('script');
    s.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    document.head.appendChild(s);
}

function injectContent(html){
    const target = document.getElementById('content-wrapper');
    if (target) target.innerHTML = html;
}

function fetchAndSwap(url, onDone){
    $.ajax({
        url: url,
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).done(function(data){
        injectContent(data);
        history.pushState({urlPath: window.location.pathname}, document.title, url);
        // Marcar estado de formulario según URL (create o edit)
        if (/\/admin\/prestamo\/create(\b|\/|\?|$)/.test(url) || /\/admin\/prestamo\/(\d+|[^\/]+)\/edit(\b|\/|\?|$)/.test(url)) {
            $('#FormOpen').val(1);
        } else {
            $('#FormOpen').val(0);
        }
        if (typeof onDone === 'function') onDone();
    }).fail(function(){
        if (typeof Swal !== 'undefined') {
            Swal.fire('Error', 'No se pudo cargar el contenido.', 'error');
        } else {
            alert('No se pudo cargar el contenido.');
        }
    });
}

function GoTo(url){
    var formOpenVal = $('#FormOpen').val();
    if (formOpenVal == 1 && typeof Swal !== 'undefined'){
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

window.addEventListener('popstate', function (event) {
    if (event.state && event.state.urlPath) {
        // Recargar el contenido para la URL actual
        $.ajax({
            url: location.pathname + location.search,
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).done(function(data){ injectContent(data); });
    }
});

// Envío AJAX de creación: sin recargar, mostrar alerta y volver al listado
$(document).on('submit', '#form-prestamo', function(e){
    e.preventDefault();
    var $form = $(this);
    var formData = new FormData(this);
    var csrf = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: $form.attr('action'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
    }).done(function(resp){
        // Volver al listado y mostrar alerta de éxito
        fetchAndSwap('/admin/prestamo', function(){
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'success', title: 'Éxito', text: (resp && resp.message) ? resp.message : 'Prestamo creado correctamente.' });
            }
        });
    }).fail(function(xhr){
        let msg = 'Error al crear el prestamo.';
        if (xhr && xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'error', title: 'Error', text: msg });
        } else {
            alert(msg);
        }
    });
});

