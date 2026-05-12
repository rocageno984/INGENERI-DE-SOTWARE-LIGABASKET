<?php /* @var array $data */ ?>
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/navbar.php'; ?>

<div class="form-container">
    <div class="form-card">
        <a href="<?php echo URL_BASE; ?>matches" class="btn-back"><i class="fas fa-arrow-left"></i> Volver</a>
        <h2><?php echo $data['title']; ?></h2>
        
        <form action="<?php echo URL_BASE; ?>matches/add" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="id_equipo_local">Equipo Local</label>
                    <select name="id_equipo_local" id="id_equipo_local" required class="<?php echo isset($data['errors']['id_equipo_local']) ? 'is-invalid' : ''; ?>">
                        <option value="">Seleccionar...</option>
                        <?php foreach($data['teams'] as $team): ?>
                            <option value="<?php echo $team->id; ?>" <?php echo ($data['id_equipo_local'] == $team->id) ? 'selected' : ''; ?>>
                                <?php echo $team->nombre; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(isset($data['errors']['id_equipo_local'])): ?>
                        <span class="error-text"><?php echo $data['errors']['id_equipo_local']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="id_equipo_visitante">Equipo Visitante</label>
                    <select name="id_equipo_visitante" id="id_equipo_visitante" required class="<?php echo isset($data['errors']['id_equipo_visitante']) ? 'is-invalid' : ''; ?>">
                        <option value="">Seleccionar...</option>
                        <?php foreach($data['teams'] as $team): ?>
                            <option value="<?php echo $team->id; ?>" <?php echo ($data['id_equipo_visitante'] == $team->id) ? 'selected' : ''; ?>>
                                <?php echo $team->nombre; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(isset($data['errors']['id_equipo_visitante'])): ?>
                        <span class="error-text"><?php echo $data['errors']['id_equipo_visitante']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="fecha_partido">Fecha y Hora</label>
                <input type="datetime-local" name="fecha_partido" id="fecha_partido" value="<?php echo $data['fecha_partido']; ?>" required class="<?php echo isset($data['errors']['fecha_partido']) ? 'is-invalid' : ''; ?>">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="puntos_local">Puntos Local</label>
                    <input type="number" name="puntos_local" id="puntos_local" value="<?php echo $data['puntos_local']; ?>" min="0">
                </div>
                <div class="form-group">
                    <label for="puntos_visitante">Puntos Visitante</label>
                    <input type="number" name="puntos_visitante" id="puntos_visitante" value="<?php echo $data['puntos_visitante']; ?>" min="0">
                </div>
            </div>
            
            <div class="form-group">
                <label for="estado">Estado del Partido</label>
                <select name="estado" id="estado">
                    <option value="Programado" <?php echo $data['estado'] == 'Programado' ? 'selected' : ''; ?>>Programado</option>
                    <option value="En curso" <?php echo $data['estado'] == 'En curso' ? 'selected' : ''; ?>>En curso</option>
                    <option value="Finalizado" <?php echo $data['estado'] == 'Finalizado' ? 'selected' : ''; ?>>Finalizado</option>
                    <option value="Cancelado" <?php echo $data['estado'] == 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Programar Partido</button>
        </form>
    </div>
</div>

<style>
    .form-container { display: flex; justify-content: center; padding: 40px 0; }
    .form-card { background: var(--surface); padding: 40px; border-radius: var(--radius); width: 100%; max-width: 700px; border: 1px solid rgba(255,255,255,0.05); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .btn-back { display: inline-flex; align-items: center; gap: 8px; color: var(--text-muted); margin-bottom: 20px; font-size: 0.9rem; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-muted); }
    .form-group input, .form-group select { width: 100%; padding: 12px 15px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white; font-family: inherit; outline: none; }
    .form-group input:focus, .form-group select:focus { border-color: var(--primary); }
    .btn-block { width: 100%; margin-top: 10px; }
    .error-text { color: var(--danger); font-size: 0.8rem; margin-top: 5px; display: block; }
    .is-invalid { border-color: var(--danger) !important; }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
