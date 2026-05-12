<?php /* @var array $data */ ?>
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/navbar.php'; ?>

<div class="page-header">
    <h1><?php echo $data['title']; ?></h1>
    <?php if(isLoggedIn()): ?>
        <a href="<?php echo URL_BASE; ?>players/add" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Jugador
        </a>
    <?php endif; ?>
</div>

<?php flash('player_message'); ?>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Equipo</th>
                <th>Posición</th>
                <th>N°</th>
                <?php if(isLoggedIn()): ?>
                    <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($data['players'])): ?>
                <tr>
                    <td colspan="5" class="text-center">No hay jugadores registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach($data['players'] as $player): ?>
                    <tr>
                        <td>
                            <div class="player-info">
                                <div class="player-avatar"><i class="fas fa-user"></i></div>
                                <div>
                                    <strong><?php echo $player->nombre . ' ' . $player->apellido; ?></strong>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge"><?php echo $player->nombre_equipo; ?></span></td>
                        <td><?php echo $player->posicion; ?></td>
                        <td><span class="player-number"><?php echo $player->numero_camiseta; ?></span></td>
                        <?php if(isLoggedIn()): ?>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo URL_BASE; ?>players/edit/<?php echo $player->id; ?>" class="btn-icon" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo URL_BASE; ?>players/delete/<?php echo $player->id; ?>" method="POST" onsubmit="return confirm('¿Eliminar jugador?');">
                                        <button type="submit" class="btn-icon btn-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .table-container {
        background: var(--surface);
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th, .data-table td {
        padding: 15px 20px;
        text-align: left;
    }
    .data-table th {
        background: rgba(255,255,255,0.02);
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }
    .data-table tr {
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .data-table tr:last-child {
        border-bottom: none;
    }
    .player-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .player-avatar {
        width: 35px;
        height: 35px;
        background: rgba(244, 121, 32, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    .badge {
        background: rgba(255, 255, 255, 0.05);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.85rem;
    }
    .player-number {
        font-weight: 800;
        color: var(--primary);
    }
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    .btn-icon {
        width: 32px;
        height: 32px;
        background: rgba(255,255,255,0.03);
        border: none;
        border-radius: 6px;
        color: var(--text);
        display: flex;
        align-items: center;
        justify-content: center;
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
    .text-center { text-align: center; }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
