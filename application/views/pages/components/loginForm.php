<section class="hw-flex-row-center hw-total-size hw-fix-section">
    <form class="hw-form hw-d-block hw-login-form" id="hw-send-form">
        <div class="hw-form-group">
            <label for="username">Usuario</label>
            <input type="text" class="hw-form-input" placeholder="Username" name="username" data-name="Usuario">
        </div>
        <div class="hw-form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="hw-form-input" placeholder="Password" name="password" data-name="Contraseña">
        </div>
        <div class="hw-form-btn-group">
            <button class="hw-btn hw-btn-primary" id="hw-send-form-button">Ingresar</button>
            <a href="<?= base_url() ?>Main/Register" class="hw-btn hw-btn-secondary">Registro</a>
        </div>
    </form>
</section>