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

<!-- Tabs Navigation -->
<div class="matches-tabs">
    <button class="tab-btn active" onclick="openTab(event, 'upcoming')">Próximos Partidos</button>
    <button class="tab-btn" onclick="openTab(event, 'past')">Resultados Pasados</button>
    <button class="tab-btn" onclick="openTab(event, 'calendar_view')"><i class="fas fa-calendar-alt"></i> Vista de Calendario</button>
</div>

<!-- Tab Content: Upcoming -->
<div id="upcoming" class="tab-content active">
    <div class="matches-list">
        <?php if(empty($data['upcomingMatches'])): ?>
            <div class="empty-state">
                <i class="fas fa-calendar-alt"></i>
                <p>No hay partidos programados para el futuro.</p>
            </div>
        <?php else: ?>
            <?php foreach($data['upcomingMatches'] as $match): ?>
                <?php include 'match_card.php'; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Tab Content: Past -->
<div id="past" class="tab-content">
    <div class="matches-list">
        <?php if(empty($data['pastMatches'])): ?>
            <div class="empty-state">
                <i class="fas fa-history"></i>
                <p>No hay registros de partidos pasados.</p>
            </div>
        <?php else: ?>
            <?php foreach($data['pastMatches'] as $match): ?>
                <?php include 'match_card.php'; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Tab Content: Calendar View -->
<div id="calendar_view" class="tab-content">
    <?php
        $month = date('m');
        $year = date('Y');
        $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
        $daysInMonth = date('t', $firstDayOfMonth);
        $dayOfWeek = date('w', $firstDayOfMonth);
        
        $monthsSpanish = [
            'January' => 'Enero', 'February' => 'Febrero', 'March' => 'Marzo', 'April' => 'Abril',
            'May' => 'Mayo', 'June' => 'Junio', 'July' => 'Julio', 'August' => 'Agosto',
            'September' => 'Septiembre', 'October' => 'Octubre', 'November' => 'Noviembre', 'December' => 'Diciembre'
        ];
        $displayMonth = $monthsSpanish[date('F', $firstDayOfMonth)] . ' ' . $year;
    ?>

    <div class="calendar-wrapper">
        <div class="calendar-header-view">
            <h3><?php echo $displayMonth; ?></h3>
        </div>
        <div class="calendar-grid">
            <div class="day-name">Dom</div>
            <div class="day-name">Lun</div>
            <div class="day-name">Mar</div>
            <div class="day-name">Mié</div>
            <div class="day-name">Jue</div>
            <div class="day-name">Vie</div>
            <div class="day-name">Sáb</div>

            <?php
            for ($i = 0; $i < $dayOfWeek; $i++) {
                echo '<div class="day empty"></div>';
            }

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = sprintf('%04d-%02d-%02d', $year, $month, $day);
                $dayMatches = [];
                
                foreach (array_merge($data['upcomingMatches'], $data['pastMatches']) as $m) {
                    if (date('Y-m-d', strtotime($m->fecha_partido)) == $currentDate) {
                        $dayMatches[] = $m;
                    }
                }

                $isToday = date('Y-m-d') == $currentDate;
                echo '<div class="day' . ($isToday ? ' today' : '') . '">';
                echo '<span class="day-number">' . $day . '</span>';
                
                if (!empty($dayMatches)) {
                    echo '<div class="day-events">';
                    foreach ($dayMatches as $dm) {
                        $status = strtolower($dm->estado);
                        $time = date('H:i', strtotime($dm->fecha_partido));
                        $score = $dm->puntos_local . '-' . $dm->puntos_visitante;
                        $teamsText = $dm->equipo_local . ' vs ' . $dm->equipo_visitante;
                        
                        echo "<div class='event-mini $status' title='$teamsText'>";
                        echo "<span class='e-time'>$time</span>";
                        echo "<span class='e-score'>$score</span>";
                        echo "</div>";
                    }
                    echo '</div>';
                }
                echo '</div>';
            }
            ?>
        </div>
        
        <div class="calendar-legend">
            <span class="legend-item"><span class="dot programado"></span> Programado</span>
            <span class="legend-item"><span class="dot en"></span> En curso</span>
            <span class="legend-item"><span class="dot finalizado"></span> Finalizado</span>
        </div>
    </div>
</div>

<script>
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].classList.remove("active");
    }
    tablinks = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }
    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
}
</script>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .matches-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding-bottom: 10px;
    }
    .tab-btn {
        background: none;
        border: none;
        color: var(--text-muted);
        padding: 10px 20px;
        font-family: inherit;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        border-radius: 8px;
    }
    .tab-btn:hover {
        background: rgba(255,255,255,0.03);
        color: var(--text);
    }
    .tab-btn.active {
        background: var(--primary);
        color: white;
    }
    
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
        animation: fadeIn 0.4s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .matches-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
        gap: 25px;
    }
    
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 0;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 20px;
        opacity: 0.2;
    }

    /* Calendar Grid Styles */
    .calendar-wrapper {
        background: var(--surface);
        padding: 30px;
        border-radius: var(--radius);
        border: 1px solid rgba(255,255,255,0.05);
        max-width: 900px;
        margin: 0 auto;
    }
    .calendar-header-view {
        text-align: center;
        margin-bottom: 30px;
    }
    .calendar-header-view h3 {
        font-size: 1.5rem;
        color: var(--primary);
    }
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
    }
    .day-name {
        text-align: center;
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        padding-bottom: 10px;
    }
    .day {
        aspect-ratio: 1 / 1;
        background: rgba(255,255,255,0.02);
        border-radius: 8px;
        padding: 10px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid rgba(255,255,255,0.03);
        transition: var(--transition);
    }
    .day:not(.empty):hover {
        background: rgba(255,255,255,0.05);
        border-color: var(--primary);
    }
    .day.today {
        border-color: var(--primary);
        background: rgba(244, 121, 32, 0.05);
    }
    .day.empty {
        background: transparent;
        border: none;
    }
    .day-number {
        font-weight: 600;
        font-size: 0.9rem;
    }
    .day.today .day-number {
        color: var(--primary);
    }
    .day-events {
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin-top: 5px;
    }
    .event-mini {
        padding: 4px 6px;
        border-radius: 4px;
        font-size: 0.65rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
        margin-bottom: 2px;
        border: none;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .event-mini.programado { background: var(--primary); }
    .event-mini.en { background: var(--success); }
    .event-mini.finalizado { background: rgba(255,255,255,0.1); color: var(--text-muted); }
    
    .e-time {
        font-weight: 700;
        opacity: 0.9;
    }
    .e-score {
        font-weight: 800;
        background: rgba(0,0,0,0.3);
        padding: 1px 4px;
        border-radius: 3px;
    }

    .calendar-legend {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    .legend-item { display: flex; align-items: center; gap: 8px; }
    .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
    .dot.programado { background: var(--accent); }
    .dot.en { background: var(--success); }
    .dot.finalizado { background: var(--text-muted); }

    @media (max-width: 600px) {
        .matches-list { grid-template-columns: 1fr; }
        .matches-tabs { flex-direction: column; }
        .calendar-grid { gap: 5px; }
        .day { padding: 5px; }
        .day-number { font-size: 0.7rem; }
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
