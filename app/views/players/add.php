<?php /* @var array $data */ ?>
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/navbar.php'; ?>

<div class="form-container">
    <div class="form-card">
        <a href="<?php echo URL_BASE; ?>players" class="btn-back"><i class="fas fa-arrow-left"></i> Volver</a>
        <h2><?php echo $data['title']; ?></h2>
        
        <form action="<?php echo URL_BASE; ?>players/add" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $data['nombre']; ?>" required class="<?php echo isset($data['errors']['nombre']) ? 'is-invalid' : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="<?php echo $data['apellido']; ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="id_equipo">Equipo</label>
                <select name="id_equipo" id="id_equipo" required class="<?php echo isset($data['errors']['id_equipo']) ? 'is-invalid' : ''; ?>">
                    <option value="">Seleccione un equipo</option>
                    <?php foreach($data['teams'] as $team): ?>
                        <option value="<?php echo $team->id; ?>" <?php echo ($data['id_equipo'] == $team->id) ? 'selected' : ''; ?>>
                            <?php echo $team->nombre; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="posicion">Posición</label>
                    <select name="posicion" id="posicion" required>
                        <option value="Base" <?php echo ($data['posicion'] == 'Base') ? 'selected' : ''; ?>>Base</option>
                        <option value="Escolta" <?php echo ($data['posicion'] == 'Escolta') ? 'selected' : ''; ?>>Escolta</option>
                        <option value="Alero" <?php echo ($data['posicion'] == 'Alero') ? 'selected' : ''; ?>>Alero</option>
                        <option value="Ala-Pívot" <?php echo ($data['posicion'] == 'Ala-Pívot') ? 'selected' : ''; ?>>Ala-Pívot</option>
                        <option value="Pívot" <?php echo ($data['posicion'] == 'Pívot') ? 'selected' : ''; ?>>Pívot</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="numero_camiseta">Número de Camiseta</label>
                    <input type="number" name="numero_camiseta" id="numero_camiseta" value="<?php echo $data['numero_camiseta']; ?>" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Guardar Jugador</button>
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
        max-width: 700px;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        margin-bottom: 20px;
        font-size: 0.9rem;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 0.9rem;
        color: var(--text-muted);
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 12px 15px;
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: white;
        font-family: inherit;
        outline: none;
    }
    .form-group input:focus, .form-group select:focus {
        border-color: var(--primary);
    }
    .btn-block {
        width: 100%;
        margin-top: 10px;
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
