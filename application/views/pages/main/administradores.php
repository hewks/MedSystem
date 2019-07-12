<!-- Admin section -->
<section class="hw-page-section hw-page-administradores">

    <!-- Table -->
    <div class="hw-page-section-table">
        <div class="hw-page-section-header">
            <div class="ps-header-section-left">
                <h4 class="hw-page-section-title"><?= $page_title ?></h4>
            </div>
            <div class="hw-header-section-right">
                <a href="<?= base_url() ?>Back/<?= $section ?>/create_pdf" class="hw-section-download"><i class="fas fa-file-export"></i></a>
                <button class="hw-section-add" data-toggle="modal" data-target="#addModal">Agregar</button>
            </div>
        </div>
        <div class="hw-page-section-body">
            <table class="hw-table table table-striped table-bordered" style="width: 100% !important;" id="tableSectionTable">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Usuario</td>
                        <td>Email</td>
                        <td>Nombre</td>
                        <td>Apellido</td>
                        <td>Act</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td>ID</td>
                        <td>Usuario</td>
                        <td>Email</td>
                        <td>Nombre</td>
                        <td>Apellido</td>
                        <td>Act</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Table -->

</section>
<!-- Admin section -->

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $page_title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="tableSection();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="hw-admin-form" id="hw-send-form">
                    <div class="hw-admin-form-group">
                        <label for="username">Usuario</label>
                        <input type="text" name="username" data-name="Usuario" class="hw-admin-input">
                    </div>
                    <div class="hw-admin-form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="passwordOne" data-name="Contraseña" class="hw-admin-input">
                    </div>
                    <div class="hw-admin-form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password-2" id="passwordTwo" data-name="Contraseña" class="hw-admin-input">
                    </div>
                    <div class="hw-admin-form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" data-name="Correo" class="hw-admin-input">
                    </div>
                    <div class="hw-admin-form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" data-name="Nombre" class="hw-admin-input">
                    </div>
                    <div class="hw-admin-form-group">
                        <label for="lastname">Apellido</label>
                        <input type="text" name="lastname" data-name="Apellido" class="hw-admin-input">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="tableSection();">Cerrar</button>
                <button type="button" class="btn btn-primary" id="hw-send-form-button">Agregar</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $page_title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="tableSection();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="hw-admin-form" id="hw-edit-form">
                    <div class="hw-admin-form-group">
                        <label for="username">Usuario</label>
                        <input type="text" name="username" data-name="Usuario" class="hw-admin-input">
                    </div>
                    <div class="hw-admin-form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" data-name="Correo" class="hw-admin-input">
                    </div>
                    <div class="hw-admin-form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" data-name="Nombre" class="hw-admin-input">
                    </div>
                    <div class="hw-admin-form-group">
                        <label for="lastname">Apellido</label>
                        <input type="text" name="lastname" data-name="Apellido" class="hw-admin-input">
                    </div>
                    <input type="hidden" name="id" data-name="ID" class="hw-admin-input">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="tableSection();">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editSection();">Agregar</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Modal -->