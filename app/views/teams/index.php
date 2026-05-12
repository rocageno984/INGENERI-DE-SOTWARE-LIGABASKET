<?php /* @var array $data */ ?>
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/navbar.php'; ?>

<div class="page-header">
    <h1><?php echo $data['title']; ?></h1>
    <a href="<?php echo URL_BASE; ?>teams/add" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Equipo
    </a>
</div>

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
                <div class="team-actions">
                    <a href="<?php echo URL_BASE; ?>teams/edit/<?php echo $team->id; ?>" class="btn-icon"><i class="fas fa-edit"></i></a>
                    <a href="<?php echo URL_BASE; ?>teams/delete/<?php echo $team->id; ?>" class="btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }
    .teams-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }
    .team-card {
        background: var(--surface);
        padding: 30px;
        border-radius: var(--radius);
        text-align: center;
        border: 1px solid rgba(255,255,255,0.05);
        transition: var(--transition);
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
    .team-logo img {
        width: 80px;
        height: 80px;
        object-fit: contain;
    }
    .team-actions {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    .btn-icon {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
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
        opacity: 0.2;
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
