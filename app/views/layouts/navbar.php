<nav class="navbar">
    <div class="navbar-brand">
        <a href="<?php echo URL_BASE; ?>">
            <span class="logo-icon"><i class="fas fa-basketball-ball"></i></span>
            <span class="logo-text">LIGA<span>PRO</span></span>
        </a>
    </div>
    <ul class="navbar-links">
        <li><a href="<?php echo URL_BASE; ?>"><i class="fas fa-home"></i> Inicio</a></li>
        <li><a href="<?php echo URL_BASE; ?>teams"><i class="fas fa-users"></i> Equipos</a></li>
        <li><a href="<?php echo URL_BASE; ?>matches"><i class="fas fa-calendar-alt"></i> Partidos</a></li>
        <li><a href="<?php echo URL_BASE; ?>stats"><i class="fas fa-chart-bar"></i> Estadísticas</a></li>
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
