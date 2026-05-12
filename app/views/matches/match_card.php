<?php /* @var stdClass $match */ ?>
<div class="match-card <?php echo strtolower($match->estado) == 'finalizado' ? 'finished' : ''; ?>">
    <div class="match-header">
        <span class="match-date"><?php echo date('d/m/Y H:i', strtotime($match->fecha_partido)); ?></span>
        <span class="match-status badge-status <?php echo strtolower($match->estado); ?>">
            <?php echo $match->estado; ?>
        </span>
    </div>
    
    <div class="match-content">
        <?php 
            $isFinished = strtolower($match->estado) == 'finalizado';
            $localWinner = $isFinished && $match->puntos_local > $match->puntos_visitante;
            $visitorWinner = $isFinished && $match->puntos_visitante > $match->puntos_local;
        ?>
        <div class="team-side local <?php echo $localWinner ? 'winner' : ''; ?>">
            <div class="team-meta">
                <span class="team-name"><?php echo $match->equipo_local; ?></span>
                <?php if($localWinner): ?>
                    <span class="winner-label"><i class="fas fa-crown"></i> GANADOR</span>
                <?php endif; ?>
            </div>
            <span class="team-score"><?php echo $match->puntos_local; ?></span>
        </div>
        
        <div class="match-vs">VS</div>
        
        <div class="team-side visitor <?php echo $visitorWinner ? 'winner' : ''; ?>">
            <span class="team-score"><?php echo $match->puntos_visitante; ?></span>
            <div class="team-meta">
                <span class="team-name"><?php echo $match->equipo_visitante; ?></span>
                <?php if($visitorWinner): ?>
                    <span class="winner-label">GANADOR <i class="fas fa-crown"></i></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php if(isLoggedIn()): ?>
        <div class="match-footer">
            <a href="<?php echo URL_BASE; ?>matches/edit/<?php echo $match->id; ?>" class="btn-text">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form action="<?php echo URL_BASE; ?>matches/delete/<?php echo $match->id; ?>" method="POST" onsubmit="return confirm('¿Eliminar este partido?');">
                <button type="submit" class="btn-text btn-danger">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Card Component Styles */
    .match-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 25px;
        border: 1px solid rgba(255,255,255,0.05);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
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
        transition: var(--transition);
        padding: 10px;
        border-radius: 12px;
    }
    .team-side.visitor { justify-content: flex-end; }
    
    .team-meta {
        display: flex;
        flex-direction: column;
    }
    .team-side.visitor .team-meta { text-align: right; }
    
    .team-name {
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .winner-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: var(--primary);
        letter-spacing: 1px;
        margin-top: 4px;
    }
    
    .team-side.winner .team-name {
        color: var(--primary);
    }
    
    .team-side.winner .team-score {
        border: 2px solid var(--primary);
        color: var(--primary);
        box-shadow: 0 0 15px rgba(244, 121, 32, 0.2);
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
</style>
