<?php /* @var array $data */ ?>
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/navbar.php'; ?>

<div class="page-header">
    <h1><?php echo $data['title']; ?></h1>
</div>

<div class="empty-state">
    <i class="fas fa-calendar-alt"></i>
    <p>El calendario de partidos se habilitará pronto.</p>
</div>

<style>
    .page-header {
        margin-bottom: 40px;
    }
    .empty-state {
        text-align: center;
        padding: 100px 0;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 5rem;
        margin-bottom: 20px;
        opacity: 0.1;
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
