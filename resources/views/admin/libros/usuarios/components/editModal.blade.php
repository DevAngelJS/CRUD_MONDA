<div class="card card-outline card-info mt-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-edit"></i> <b>Editar Usuario</b></h3>
    </div>

    <form id="editUserForm" class="editUserForm" method="POST">
        @csrf
        <input type="hidden" name="_method" value="POST">

        <div class="card-body">
            <div class="form-group">
                <label for="edit_perfil">Perfil</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text inline-block"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="form-control" id="edit_perfil" name="perfil" required>
                        <option value="administrador">Administrador</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="bibliotecario">Bibliotecario</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="edit_name">Nombre completo</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text inline-block"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="edit_name" name="name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="edit_email">Correo electrónico</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text inline-block"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control" id="edit_email" name="email" required>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <button type="button" class="btn btn-secondary btn-volver" style="margin-right: 5px">Volver</button>
            <button type="submit" class="btn btn-warning text-white">
                <i class="fas fa-save"></i> Actualizar
            </button>
        </div>
    </form>
</div>
