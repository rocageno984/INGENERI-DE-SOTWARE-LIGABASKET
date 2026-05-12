<?php /* @var array $data */ ?>
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/navbar.php'; ?>

<div class="form-container">
    <div class="form-card">
        <a href="<?php echo URL_BASE; ?>teams" class="btn-back"><i class="fas fa-arrow-left"></i> Volver</a>
        <h2><?php echo $data['title']; ?></h2>
        
        <form action="<?php echo URL_BASE; ?>teams/add" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Equipo</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo $data['nombre']; ?>" placeholder="Ej. Los Titanes" required class="<?php echo isset($data['errors']['nombre']) ? 'is-invalid' : ''; ?>">
                <?php if(isset($data['errors']['nombre'])): ?>
                    <span class="error-text"><?php echo $data['errors']['nombre']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <input type="text" name="ciudad" id="ciudad" value="<?php echo $data['ciudad']; ?>" placeholder="Ej. Cusco" required class="<?php echo isset($data['errors']['ciudad']) ? 'is-invalid' : ''; ?>">
                <?php if(isset($data['errors']['ciudad'])): ?>
                    <span class="error-text"><?php echo $data['errors']['ciudad']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="nombre_entrenador">Nombre del Entrenador</label>
                <input type="text" name="nombre_entrenador" id="nombre_entrenador" value="<?php echo $data['nombre_entrenador']; ?>" placeholder="Ej. Ricardo Gareca">
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Guardar Equipo</button>
        </form>
    </div>
</div>

<style>
    .form-container {
        display: flex;
        justify-content: center;
        padding: 40px 0;
    }
    .form-card {
        background: var(--surface);
        padding: 40px;
        border-radius: var(--radius);
        width: 100%;
        max-width: 600px;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        margin-bottom: 20px;
        font-size: 0.9rem;
    }
    .btn-back:hover {
        color: var(--primary);
    }
    .form-card h2 {
        margin-bottom: 30px;
        font-size: 1.8rem;
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
    }
    .form-group input:focus {
        border-color: var(--primary);
    }
    .is-invalid {
        border-color: var(--danger) !important;
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
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
