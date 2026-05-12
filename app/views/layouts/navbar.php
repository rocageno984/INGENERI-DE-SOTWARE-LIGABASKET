<nav class="navbar">
    <div class="navbar-brand">
        <a href="<?php echo URL_BASE; ?>">
            <span class="logo-icon"><i class="fas fa-basketball-ball"></i></span>
            <span class="logo-text">LIGA<span>PRO</span></span>
        </a>
    </div>
    <div class="navbar-toggle" id="mobile-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    <div class="navbar-menu-container">
        <ul class="navbar-links">
            <li><a href="<?php echo URL_BASE; ?>" class="<?php echo ($data['active'] ?? '') == 'home' ? 'active' : ''; ?>"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="<?php echo URL_BASE; ?>teams" class="<?php echo ($data['active'] ?? '') == 'teams' ? 'active' : ''; ?>"><i class="fas fa-users"></i> Equipos</a></li>
            <li><a href="<?php echo URL_BASE; ?>players" class="<?php echo ($data['active'] ?? '') == 'players' ? 'active' : ''; ?>"><i class="fas fa-running"></i> Jugadores</a></li>
            <li><a href="<?php echo URL_BASE; ?>matches" class="<?php echo ($data['active'] ?? '') == 'matches' ? 'active' : ''; ?>"><i class="fas fa-calendar-alt"></i> Partidos</a></li>
            <li><a href="<?php echo URL_BASE; ?>stats" class="<?php echo ($data['active'] ?? '') == 'stats' ? 'active' : ''; ?>"><i class="fas fa-chart-bar"></i> Estadísticas</a></li>
        </ul>
        <div class="navbar-actions">
            <?php if(isset($_SESSION['user_id'])) : ?>
                <div class="user-menu">
                    <span class="user-welcome">Hola, <strong><?php echo $_SESSION['user_name']; ?></strong></span>
                    <a href="<?php echo URL_BASE; ?>users/logout" class="btn btn-outline"><i class="fas fa-sign-out-alt"></i> Salir</a>
                </div>
            <?php else : ?>
                <a href="<?php echo URL_BASE; ?>users/login" class="btn btn-outline">Ingresar</a>
                <a href="<?php echo URL_BASE; ?>users/register" class="btn btn-primary">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<style>
    .user-menu {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .user-welcome {
        font-size: 0.9rem;
        color: var(--text-muted);
    }
    .user-welcome strong {
        color: var(--text);
    }
</style>

<main class="content">
