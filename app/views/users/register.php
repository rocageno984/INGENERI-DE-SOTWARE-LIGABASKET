<?php /* @var array $data */ ?>
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/navbar.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h2><?php echo $data['title']; ?></h2>
        <p>Únete a la liga y empieza a gestionar tu equipo.</p>
        
        <form action="<?php echo URL_BASE; ?>users/register" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo $data['nombre']; ?>" placeholder="Ej. Juan Pérez" required class="<?php echo isset($data['errors']['nombre']) ? 'is-invalid' : ''; ?>">
                <?php if(isset($data['errors']['nombre'])): ?>
                    <span class="error-text"><?php echo $data['errors']['nombre']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" name="email" id="email" value="<?php echo $data['email']; ?>" placeholder="ejemplo@correo.com" required class="<?php echo isset($data['errors']['email']) ? 'is-invalid' : ''; ?>">
                <?php if(isset($data['errors']['email'])): ?>
                    <span class="error-text"><?php echo $data['errors']['email']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" value="<?php echo $data['password']; ?>" placeholder="Mínimo 6 caracteres" required minlength="6" class="<?php echo isset($data['errors']['password']) ? 'is-invalid' : ''; ?>">
                <?php if(isset($data['errors']['password'])): ?>
                    <span class="error-text"><?php echo $data['errors']['password']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmar Contraseña</label>
                <input type="password" name="confirm_password" id="confirm_password" value="<?php echo $data['confirm_password']; ?>" placeholder="Repite tu contraseña" required minlength="6" class="<?php echo isset($data['errors']['confirm_password']) ? 'is-invalid' : ''; ?>">
                <?php if(isset($data['errors']['confirm_password'])): ?>
                    <span class="error-text"><?php echo $data['errors']['confirm_password']; ?></span>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
        </form>
        
        <div class="auth-footer">
            <p>¿Ya tienes una cuenta? <a href="<?php echo URL_BASE; ?>users/login">Inicia sesión</a></p>
        </div>
    </div>
</div>

<style>
    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 0;
    }
    .auth-card {
        background: var(--surface);
        padding: 40px;
        border-radius: var(--radius);
        width: 100%;
        max-width: 500px;
        border: 1px solid rgba(255,255,255,0.05);
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    }
    .auth-card h2 {
        font-size: 2rem;
        margin-bottom: 10px;
        text-align: center;
    }
    .auth-card p {
        color: var(--text-muted);
        text-align: center;
        margin-bottom: 30px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    .form-group input {
        width: 100%;
        padding: 12px 15px;
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: white;
        font-family: inherit;
        outline: none;
        transition: var(--transition);
    }
    .form-group input:focus {
        border-color: var(--primary);
        background: rgba(255,255,255,0.06);
    }
    .form-group input.is-invalid {
        border-color: var(--danger);
    }
    .error-text {
        color: var(--danger);
        font-size: 0.8rem;
        margin-top: 5px;
        display: block;
    }
    .btn-block {
        width: 100%;
        margin-top: 10px;
    }
    .auth-footer {
        margin-top: 30px;
        text-align: center;
        font-size: 0.9rem;
    }
    .auth-footer a {
        color: var(--primary);
        font-weight: 600;
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
