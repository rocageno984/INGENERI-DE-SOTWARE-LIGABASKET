<?php /* @var array $data */ ?>
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/navbar.php'; ?>

<div class="hero-section">
    <h1><?php echo $data['title']; ?></h1>
    <p><?php echo $data['description']; ?></p>
    
    <div class="hero-stats">
        <div class="stat-card">
            <i class="fas fa-users"></i>
            <h3>12</h3>
            <p>Equipos</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-running"></i>
            <h3>150</h3>
            <p>Jugadores</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-trophy"></i>
            <h3>24</h3>
            <p>Partidos</p>
        </div>
    </div>
</div>

<style>
    .hero-section {
        text-align: center;
        padding: 60px 0;
    }
    .hero-section h1 {
        font-size: 3.5rem;
        margin-bottom: 20px;
        background: linear-gradient(to right, #fff, var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .hero-section p {
        font-size: 1.2rem;
        color: var(--text-muted);
        margin-bottom: 40px;
    }
    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 40px;
    }
    .stat-card {
        background: var(--surface);
        padding: 30px;
        border-radius: var(--radius);
        min-width: 180px;
        border: 1px solid rgba(255,255,255,0.05);
        transition: var(--transition);
    }
    .stat-card:hover {
        transform: translateY(-10px);
        border-color: var(--primary);
    }
    .stat-card i {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 15px;
    }
    .stat-card h3 {
        font-size: 2rem;
        margin-bottom: 5px;
    }
    .stat-card p {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
