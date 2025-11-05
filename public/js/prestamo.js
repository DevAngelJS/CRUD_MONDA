// ---------------------- Inicio: Inicialización dinámica del formulario ----------------------
/**
 * initPrestamoForm: inicializa todos los handlers del formulario de préstamo.
 * Llamar cada vez que se inserte el HTML del formulario por AJAX.
 */
window.initPrestamoForm = function initPrestamoForm() {
    // ocultarMensajes() ya lo tienes definido; ejecutarlo si existe
    if (typeof ocultarMensajes === 'function') ocultarMensajes();

    // Soportar ambos IDs (form-prestamo o editForm)
    const form = document.getElementById('form-prestamo') || document.getElementById('editForm');
    if (!form) return;

    // ---------------- Opciones del select de libros ----------------
    // Si el servidor provee window.librosOptions puedes usarlo.
    // Si no, tomamos las opciones del primer select-libro existente.
    let opcionesHTML = (window.librosOptions && String(window.librosOptions).trim().length) ? window.librosOptions : null;
    if (!opcionesHTML) {
        const primerSelect = form.querySelector('.select-libro');
        if (primerSelect) opcionesHTML = primerSelect.innerHTML;
        else opcionesHTML = '<option value="">Seleccione un libro</option>';
    }

    // ---------------- Contador inicial (busca el mayor índice en los name existentes) ----------------
    let contadorLibros = 0;
    const nameRegex = /libros\[(\d+)\]\[libro_id\]/;
    form.querySelectorAll('select[name]').forEach(s => {
        const match = s.name.match(nameRegex);
        if (match && match[1]) {
            const idx = parseInt(match[1], 10);
            if (!isNaN(idx) && idx > contadorLibros) contadorLibros = idx;
        }
    });
    // Aseguramos que el siguiente sea +1
    contadorLibros = contadorLibros;

    // ---------------- Funciones auxiliares ----------------
    function actualizarBotonesEliminar() {
        const botones = form.querySelectorAll('.btn-eliminar-libro');
        const items = form.querySelectorAll('.libro-item');
        botones.forEach(boton => {
            boton.disabled = (items.length === 1);
            if (boton.disabled) boton.classList.add('disabled'); else boton.classList.remove('disabled');
        });
    }

    function crearElementoLibro(index) {
        return `
            <div class="row libro-item mb-3">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Libro</label>
                        <select class="form-control select-libro" name="libros[${index}][libro_id]" required>
                            ${opcionesHTML}
                        </select>
                        <div class="invalid-feedback d-none" id="libro-${index}-error"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Cantidad</label>
                        <input type="number" class="form-control cantidad-libro" 
                               name="libros[${index}][cantidad]" min="1" value="1" required>
                        <div class="invalid-feedback d-none" id="cantidad-${index}-error"></div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center mt-3">
                    <button type="button" class="btn btn-danger btn-eliminar-libro">
                        <i class="fas fa-trash"></i> Quitar
                    </button>
                </div>
            </div>
        `;
    }

    // ---------------- Event: Agregar libro ----------------
    const btnAgregar = form.querySelector('#agregar-libro');
    if (btnAgregar) {
        // quitar listeners previos para evitar duplicados
        btnAgregar.replaceWith(btnAgregar.cloneNode(true));
    }
    const btnAgregarNuevo = form.querySelector('#agregar-libro');
    if (btnAgregarNuevo) {
        btnAgregarNuevo.addEventListener('click', function () {
            contadorLibros++;
            const container = form.querySelector('#libros-container');
            if (!container) return;
            container.insertAdjacentHTML('beforeend', crearElementoLibro(contadorLibros));
            actualizarBotonesEliminar();
        });
    }

    // ---------------- Delegación: Eliminar libro (delegación local al contenedor del form) ----------------
    const librosContainer = form.querySelector('#libros-container');
    if (librosContainer) {
        // eliminar event listener previo si existiera (evitar duplicados)
        librosContainer.replaceWith(librosContainer.cloneNode(true));
    }
    const librosContainerNuevo = form.querySelector('#libros-container');
    if (librosContainerNuevo) {
        librosContainerNuevo.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-eliminar-libro');
            if (!btn) return;
            const items = form.querySelectorAll('.libro-item');
            if (items.length > 1) {
                const fila = btn.closest('.libro-item');
                if (fila) fila.remove();
                actualizarBotonesEliminar();
            }
        });
    }

    // ---------------- Validaciones y comportamiento de inputs que tenías ----------------
    // Quitar clase is-invalid al escribir
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        // remover listeners previos para evitar duplicados (si se re-inicia varias veces)
        input.removeEventListener('input', input._removeInvalidListener);
        const listener = function () {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
                const errorMsg = this.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                    errorMsg.style.display = 'none';
                }
            }
        };
        input.addEventListener('input', listener);
        input._removeInvalidListener = listener;

        if (input.type === 'date') {
            input.removeEventListener('change', input._dateListener);
            const dateListener = function () {
                if (this.value) {
                    this.classList.remove('is-invalid');
                    const errorMsg = this.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                        errorMsg.style.display = 'none';
                    }
                }
            };
            input.addEventListener('change', dateListener);
            input._dateListener = dateListener;
        }
    });

    // Forzar cantidad mínima a 1
    form.removeEventListener('change', form._cantidadListener);
    const cantidadListener = function (e) {
        if (e.target && e.target.classList && e.target.classList.contains('cantidad-libro')) {
            if (Number(e.target.value) < 1 || e.target.value === '') e.target.value = 1;
        }
    };
    form.addEventListener('change', cantidadListener);
    form._cantidadListener = cantidadListener;

    // ---------------- Contador de caracteres para descripción ----------------
    const descripcionField = form.querySelector('#descripcion');
    const contador = form.querySelector('#contador-caracteres');
    if (descripcionField) {
        descripcionField.removeEventListener('input', descripcionField._charListener);
        const charListener = function () {
            if (contador) contador.textContent = this.value.length;
        };
        descripcionField.addEventListener('input', charListener);
        descripcionField._charListener = charListener;
        // set initial counter text
        if (contador) contador.textContent = descripcionField.value.length;
    }

    // ---------------- Reset del formulario: re-inicializar (para mantener estado consistente) ----------------
    form.removeEventListener('reset', form._resetListener);
    const resetListener = function () {
        // esperar que el reset se aplique
        setTimeout(() => {
            initPrestamoForm();
        }, 50);
    };
    form.addEventListener('reset', resetListener);
    form._resetListener = resetListener;

    // Finalmente actualizar botones eliminar según el estado actual
    actualizarBotonesEliminar();
};

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


// Reemplaza o añade este handler (asegúrate de que esté cargado después de jQuery)
$(document).on('submit', '#editForm, .editForm', function(e){
    e.preventDefault();
    var $form = $(this);
    var formData = new FormData(this);
    var csrf = $('meta[name="csrf-token"]').attr('content');

    // Si usas method spoofing (<input name="_method" value="PUT">) lo tomamos:
    var method = ($form.find('input[name="_method"]').val() || $form.attr('method') || 'POST').toUpperCase();

    $.ajax({
    url: $form.attr('action'),
    method: method,
    data: formData,
    processData: false,
    contentType: false,
    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
    }).done(function(resp){
        if (resp && resp.status === 'success') {
            if (typeof fetchAndSwap === 'function') {
                fetchAndSwap(window.routePrestamoIndex, function(){
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'success', title: 'Éxito', text: resp.message || 'Préstamo actualizado correctamente.' });
                    }
                });
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Éxito', text: resp.message || 'Préstamo actualizado correctamente.' })
                    .then(() => window.location.href = window.routePrestamoIndex);
                } else {
                    window.location.href = window.routePrestamoIndex;
                }
            }
        } else {
            var msg = (resp && resp.message) ? resp.message : 'Respuesta inesperada del servidor.';
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            } else { alert(msg); }
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

        // <-- RE-INITIALIZAR aquí -->
        if (typeof window.initPrestamoForm === 'function') {
            try { window.initPrestamoForm(); } catch(err) { console.error('Error initPrestamoForm:', err); }
        }

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

// ---------------------- Ejecutar init al cargar la página por primera vez ----------------------
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.initPrestamoForm === 'function') window.initPrestamoForm();
});

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
        headers: { 
            'X-Requested-With': 'XMLHttpRequest', 
            'X-CSRF-TOKEN': csrf, 
            'Accept': 'application/json' 
        }
    }).done(function(resp){
        // Éxito: volver al listado y mostrar alerta
        if (resp && resp.status === 'success') {
            if (typeof fetchAndSwap === 'function') {
                fetchAndSwap(window.routePrestamoIndex, function(){
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: resp.message || 'Préstamo creado correctamente.'
                        });
                    }
                });
            } else {
                // Si no existe fetchAndSwap, recargar con redirect
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: resp.message || 'Préstamo creado correctamente.'
                    }).then(() => window.location.href = window.routePrestamoIndex);
                } else {
                    window.location.href = window.routePrestamoIndex;
                }
            }
        } else {
            // Si la respuesta no tiene status esperado
            var msg = (resp && resp.message) ? resp.message : 'Respuesta inesperada del servidor.';
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            } else { alert(msg); }
        }
    }).fail(function(xhr){
        let msg = 'Error al crear el préstamo.';
        if (xhr && xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'error', title: 'Error', text: msg });
        } else {
            alert(msg);
        }
    });
});


