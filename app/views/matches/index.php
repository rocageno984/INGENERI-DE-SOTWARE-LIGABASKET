<?php /* @var array $data */ ?>
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/navbar.php'; ?>

<div class="page-header">
    <h1><?php echo $data['title']; ?></h1>
    <?php if(isLoggedIn()): ?>
        <a href="<?php echo URL_BASE; ?>matches/add" class="btn btn-primary">
            <i class="fas fa-plus"></i> Programar Partido
        </a>
    <?php endif; ?>
</div>

<?php flash('match_message'); ?>

<div class="matches-list">
    <?php if(empty($data['matches'])): ?>
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <p>No hay partidos programados.</p>
        </div>
    <?php else: ?>
        <?php foreach($data['matches'] as $match): ?>
            <div class="match-card <?php echo strtolower($match->estado) == 'finalizado' ? 'finished' : ''; ?>">
                <div class="match-header">
                    <span class="match-date"><?php echo date('d/m/Y H:i', strtotime($match->fecha_partido)); ?></span>
                    <span class="match-status badge-status <?php echo strtolower($match->estado); ?>">
                        <?php echo $match->estado; ?>
                    </span>
                </div>
                
                <div class="match-content">
                    <div class="team-side local">
                        <span class="team-name"><?php echo $match->equipo_local; ?></span>
                        <span class="team-score"><?php echo $match->puntos_local; ?></span>
                    </div>
                    
                    <div class="match-vs">VS</div>
                    
                    <div class="team-side visitor">
                        <span class="team-score"><?php echo $match->puntos_visitante; ?></span>
                        <span class="team-name"><?php echo $match->equipo_visitante; ?></span>
                    </div>
                </div>
                
                <?php if(isLoggedIn()): ?>
                    <div class="match-footer">
                        <a href="<?php echo URL_BASE; ?>matches/edit/<?php echo $match->id; ?>" class="btn-text">
                            <i class="fas fa-edit"></i> Editar Resultado / Datos
                        </a>
                        <form action="<?php echo URL_BASE; ?>matches/delete/<?php echo $match->id; ?>" method="POST" onsubmit="return confirm('¿Eliminar este partido?');">
                            <button type="submit" class="btn-text btn-danger">
                                <i class="fas fa-trash"></i> Eliminar
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
        margin-bottom: 30px;
    }
    .matches-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
        gap: 25px;
    }
    .match-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 25px;
        border: 1px solid rgba(255,255,255,0.05);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    .match-card:hover {
        border-color: var(--primary);
        transform: translateY(-5px);
    }
    .match-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        font-size: 0.85rem;
    }
    .match-date {
        color: var(--text-muted);
    }
    .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .badge-status.programado { background: rgba(241, 196, 15, 0.1); color: var(--accent); }
    .badge-status.en { background: rgba(16, 185, 129, 0.1); color: var(--success); }
    .badge-status.finalizado { background: rgba(255, 255, 255, 0.05); color: var(--text-muted); }
    
    .match-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
    }
    .team-side {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
    }
    .team-side.visitor { justify-content: flex-end; }
    .team-name {
        font-weight: 700;
        font-size: 1.1rem;
    }
    .team-score {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
        background: rgba(255,255,255,0.02);
        padding: 10px 15px;
        border-radius: 8px;
        min-width: 60px;
        text-align: center;
    }
    .match-vs {
        padding: 0 20px;
        font-weight: 800;
        opacity: 0.3;
        font-size: 0.9rem;
    }
    .match-footer {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.05);
        display: flex;
        justify-content: center;
        gap: 30px;
    }
    .btn-text {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 0.85rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
    }
    .btn-text:hover { color: var(--primary); }
    .btn-text.btn-danger:hover { color: var(--danger); }
    
    @media (max-width: 600px) {
        .matches-list { grid-template-columns: 1fr; }
        .match-content { flex-direction: column; gap: 20px; }
        .team-side { width: 100%; justify-content: space-between; }
        .team-side.visitor { flex-direction: row-reverse; }
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
