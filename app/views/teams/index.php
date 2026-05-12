<?php /* @var array $data */ ?>
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/navbar.php'; ?>

<div class="page-header">
    <h1><?php echo $data['title']; ?></h1>
    <?php if(isLoggedIn()): ?>
        <a href="<?php echo URL_BASE; ?>teams/add" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Equipo
        </a>
    <?php endif; ?>
</div>

<?php flash('team_message'); ?>

<div class="teams-grid">
    <?php if(empty($data['teams'])): ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <p>No hay equipos registrados todavía.</p>
        </div>
    <?php else: ?>
        <?php foreach($data['teams'] as $team): ?>
            <div class="team-card">
                <div class="team-logo">
                    <i class="fas fa-basketball-ball"></i>
                </div>
                <h3><?php echo $team->nombre; ?></h3>
                <p><strong>Ciudad:</strong> <?php echo $team->ciudad; ?></p>
                <p><strong>Entrenador:</strong> <?php echo $team->nombre_entrenador ?: 'No asignado'; ?></p>
                
                <?php if(isLoggedIn()): ?>
                    <div class="team-actions">
                        <a href="<?php echo URL_BASE; ?>teams/edit/<?php echo $team->id; ?>" class="btn-icon" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo URL_BASE; ?>teams/delete/<?php echo $team->id; ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este equipo?');">
                            <button type="submit" class="btn-icon btn-danger" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    /* Flash message style */
    .alert {
        padding: 15px;
        margin-bottom: 30px;
        border-radius: var(--radius);
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid var(--success);
        color: var(--success);
        text-align: center;
    }
    .teams-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }
    .team-card {
        background: var(--surface);
        padding: 30px;
        border-radius: var(--radius);
        text-align: center;
        border: 1px solid rgba(255,255,255,0.05);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
    }
    .team-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary);
    }
    .team-logo {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 15px;
    }
    .team-card h3 {
        font-size: 1.4rem;
        margin-bottom: 10px;
    }
    .team-card p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 5px;
    }
    .team-actions {
        margin-top: auto;
        padding-top: 25px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    .btn-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.05);
        border: none;
        border-radius: 10px;
        color: var(--text);
        cursor: pointer;
        transition: var(--transition);
    }
    .btn-icon:hover {
        background: var(--primary);
        color: white;
    }
    .btn-icon.btn-danger:hover {
        background: var(--danger);
    }
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.1;
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
