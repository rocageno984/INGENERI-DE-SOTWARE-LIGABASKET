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
                
                <div class="team-players-mini">
                    <div class="mini-header">
                        <h4>Plantel:</h4>
                        <?php if(isLoggedIn()): ?>
                            <a href="<?php echo URL_BASE; ?>players/add/<?php echo $team->id; ?>" class="btn-add-mini" title="Agregar jugador a este equipo">
                                <i class="fas fa-plus"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php if(empty($team->players)): ?>
                        <span class="no-players">Sin jugadores registrados</span>
                    <?php else: ?>
                        <ul>
                            <?php foreach(array_slice($team->players, 0, 5) as $player): ?>
                                <li>
                                    <span class="mini-number"><i class="fas fa-tshirt"></i> <?php echo $player->numero_camiseta; ?></span>
                                    <span class="mini-name"><?php echo $player->nombre; ?></span>
                                    <span class="mini-pos">(<?php echo $player->posicion; ?>)</span>
                                </li>
                            <?php endforeach; ?>
                            <?php if(count($team->players) > 5): ?>
                                <li class="more-players">+<?php echo count($team->players) - 5; ?> más</li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <?php if(isLoggedIn()): ?>
                    <div class="team-actions">
                        <button type="button" class="btn-icon btn-tactic" title="Ver Táctica" 
                                onclick='openTacticsModal(<?php echo json_encode($team->nombre); ?>, <?php echo json_encode($team->players); ?>)'>
                            <i class="fas fa-chalkboard-teacher"></i>
                        </button>
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

<!-- Modal de Táctica -->
<div id="tacticModal" class="tactic-modal">
    <div class="tactic-modal-content">
        <div class="tactic-modal-header">
            <h2 id="modalTeamName">Táctica del Equipo</h2>
            <button class="close-modal" onclick="closeTacticsModal()">&times;</button>
        </div>
        <div class="tactic-modal-body">
            <div class="basketball-court">
                <div class="svg-court-wrapper">
                    <?php echo file_get_contents('../public/img/cancha.svg'); ?>
                </div>
                
                <!-- Posiciones de los jugadores -->
                <div id="player-base" class="player-marker" title="Base">
                    <div class="jersey-icon"><i class="fas fa-tshirt"></i><span class="p-num">?</span></div>
                    <span class="p-name">Base</span>
                </div>
                <div id="player-escolta" class="player-marker" title="Escolta">
                    <div class="jersey-icon"><i class="fas fa-tshirt"></i><span class="p-num">?</span></div>
                    <span class="p-name">Escolta</span>
                </div>
                <div id="player-alero" class="player-marker" title="Alero">
                    <div class="jersey-icon"><i class="fas fa-tshirt"></i><span class="p-num">?</span></div>
                    <span class="p-name">Alero</span>
                </div>
                <div id="player-ala-pivot" class="player-marker" title="Ala-Pívot">
                    <div class="jersey-icon"><i class="fas fa-tshirt"></i><span class="p-num">?</span></div>
                    <span class="p-name">Ala-Pívot</span>
                </div>
                <div id="player-pivot" class="player-marker" title="Pívot">
                    <div class="jersey-icon"><i class="fas fa-tshirt"></i><span class="p-num">?</span></div>
                    <span class="p-name">Pívot</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openTacticsModal(teamName, players) {
    document.getElementById('modalTeamName').innerText = 'Táctica: ' + teamName;
    const modal = document.getElementById('tacticModal');
    
    // Reset markers
    const markers = ['base', 'escolta', 'alero', 'ala-pivot', 'pivot'];
    markers.forEach(pos => {
        const marker = document.getElementById('player-' + pos);
        marker.classList.remove('active');
        marker.querySelector('.p-num').innerText = '?';
        marker.querySelector('.p-name').innerText = pos.charAt(0).toUpperCase() + pos.slice(1).replace('-', ' ');
    });

    // Fill markers with players
    players.forEach(player => {
        let posKey = player.posicion.toLowerCase()
            .replace('pívot', 'pivot')
            .replace('pivote', 'pivot')
            .replace('ala-pivot', 'ala-pivot')
            .replace('ala pívot', 'ala-pivot')
            .replace('ala-pívot', 'ala-pivot');
            
        const marker = document.getElementById('player-' + posKey);
        if (marker) {
            marker.classList.add('active');
            marker.querySelector('.p-num').innerText = player.numero_camiseta;
            marker.querySelector('.p-name').innerText = player.nombre;
        }
    });

    modal.style.display = 'flex';
    setTimeout(() => modal.classList.add('show'), 10);
}

function closeTacticsModal() {
    const modal = document.getElementById('tacticModal');
    modal.classList.remove('show');
    setTimeout(() => modal.style.display = 'none', 300);
}

// Close on outside click
window.onclick = function(event) {
    const modal = document.getElementById('tacticModal');
    if (event.target == modal) {
        closeTacticsModal();
    }
}
</script>

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
    .team-players-mini {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid rgba(255,255,255,0.03);
        text-align: left;
    }
    .mini-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .btn-add-mini {
        width: 22px;
        height: 22px;
        background: rgba(244, 121, 32, 0.1);
        color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        transition: var(--transition);
    }
    .btn-add-mini:hover {
        background: var(--primary);
        color: white;
        transform: scale(1.1);
    }
    .team-players-mini h4 {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
    }
    .team-players-mini ul {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .team-players-mini li {
        font-size: 0.85rem;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .mini-number {
        font-weight: 700;
        color: var(--primary);
        font-size: 0.75rem;
        width: 45px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .mini-number i {
        font-size: 0.7rem;
        opacity: 0.8;
    }
    .mini-name {
        flex: 1;
    }
    .mini-pos {
        font-size: 0.7rem;
        color: var(--text-muted);
        font-style: italic;
    }
    .more-players {
        color: var(--primary) !important;
        font-weight: 600;
        margin-top: 5px;
    }
    .no-players {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-style: italic;
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

    /* Tactic Modal Styles */
    .tactic-modal {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.85);
        backdrop-filter: blur(10px);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .tactic-modal.show { opacity: 1; }
    
    .tactic-modal-content {
        background: #0f172a;
        width: 95%;
        max-width: 800px;
        border-radius: 24px;
        padding: 20px;
        border: 1px solid rgba(244, 121, 32, 0.2);
        transform: scale(0.9);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    .tactic-modal.show .tactic-modal-content { transform: scale(1); }
    
    .tactic-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .tactic-modal-header h2 { color: #fff; font-size: 1.2rem; }
    .close-modal {
        background: none;
        border: none;
        color: rgba(255,255,255,0.5);
        font-size: 2rem;
        cursor: pointer;
    }
    
    .basketball-court {
        width: 100%;
        aspect-ratio: 1 / 1.1;
        background: #0b1121;
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .svg-court-wrapper {
        width: 100%;
        height: 100%;
        /* No rotation - Basket at bottom */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }
    
    .svg-court-wrapper svg {
        width: 100%;
        height: 100%;
    }
    
    /* Paint the SVG lines with a single color and transparency */
    .svg-court-wrapper svg path,
    .svg-court-wrapper svg circle,
    .svg-court-wrapper svg rect,
    .svg-court-wrapper svg line {
        stroke: rgba(244, 121, 32, 0.4) !important;
        fill: transparent !important;
        stroke-width: 1.5px !important;
    }
    
    /* Player Markers - Positioning for Bottom Basket View */
    .player-marker {
        position: absolute;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        transition: all 0.5s ease;
        opacity: 0.2;
        z-index: 5;
    }
    .player-marker.active { opacity: 1; transform: scale(1.1); }
    
    .jersey-icon {
        position: relative;
        font-size: 2.2rem;
        color: var(--primary);
        filter: drop-shadow(0 0 10px rgba(244, 121, 32, 0.3));
    }
    .p-num {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -40%);
        font-size: 0.8rem;
        font-weight: 800;
        color: white;
    }
    .p-name {
        background: rgba(244, 121, 32, 0.9);
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.65rem;
        font-weight: 600;
        white-space: nowrap;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    
    /* Updated Positioning (Basket at Bottom) */
    #player-base { top: 15%; left: 50%; transform: translateX(-50%); }
    #player-escolta { top: 40%; left: 15%; }
    #player-alero { top: 40%; right: 15%; }
    #player-ala-pivot { bottom: 30%; left: 25%; }
    #player-pivot { bottom: 15%; left: 50%; transform: translateX(-50%); }

    .btn-tactic:hover { color: var(--accent); background: rgba(241, 196, 15, 0.1); }

</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
