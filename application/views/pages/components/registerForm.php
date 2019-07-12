<section class="hw-flex-row-center hw-total-size  hw-fix-section">
    <form class="hw-form hw-d-block hw-register-form" id="hw-send-form">
        <div class="hw-form-group">
            <label for="username">Usuario</label>
            <input type="text" class="hw-form-input" placeholder="Username" name="username" data-name="Usuario">
        </div>
        <div class="hw-form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="passwordOne" class="hw-form-input" placeholder="Password" name="password" data-name="Contraseña">
        </div>
        <div class="hw-form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="passwordTwo" class="hw-form-input" placeholder="Password" name="password" data-name="Contraseña 2">
        </div>
        <div class="hw-form-group">
            <label for="email">Email</label>
            <input type="email" class="hw-form-input" placeholder="Email" name="email" data-name="Correo electronico">
        </div>
        <div class="hw-form-btn-group">
            <button class="hw-btn hw-btn-primary" id="hw-send-form-button">Registrar</button>
            <a href="<?= base_url() ?>Main" class="hw-btn hw-btn-secondary">Ingresar</a>
        </div>
    </form>
</section>