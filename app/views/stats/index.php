<?php /* @var array $data */ ?>
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/navbar.php'; ?>

<div class="page-header">
    <h1><i class="fas fa-chart-line"></i> <?php echo $data['title']; ?></h1>
</div>

<!-- Tabs Navigation -->
<div class="stats-tabs">
    <button class="tab-btn active" onclick="openTab(event, 'standings')">Tabla de Posiciones</button>
    <button class="tab-btn" onclick="openTab(event, 'playoffs')">Árbol de Play-offs</button>
</div>

<!-- Tab Content: Standings -->
<div id="standings" class="tab-content active">
    <div class="stats-container">
        <div class="table-responsive">
            <table class="standings-table">
                <thead>
                    <tr>
                        <th class="pos">Pos</th>
                        <th class="team">Equipo</th>
                        <th class="stat">PJ</th>
                        <th class="stat">PG</th>
                        <th class="stat">PP</th>
                        <th class="stat pf">PF</th>
                        <th class="stat pc">PC</th>
                        <th class="stat dif">DIF</th>
                        <th class="stat pts">PTS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['standings'] as $index => $row): ?>
                        <tr class="<?php echo $index < 8 ? 'playoff-zone' : ''; ?>">
                            <td class="pos"><?php echo $index + 1; ?></td>
                            <td class="team">
                                <div class="team-info">
                                    <span class="team-icon"><i class="fas fa-basketball-ball"></i></span>
                                    <strong><?php echo $row->nombre; ?></strong>
                                </div>
                            </td>
                            <td class="stat"><?php echo $row->PJ; ?></td>
                            <td class="stat pg"><?php echo $row->PG; ?></td>
                            <td class="stat pp"><?php echo $row->PP; ?></td>
                            <td class="stat pf"><?php echo $row->PF ?: 0; ?></td>
                            <td class="stat pc"><?php echo $row->PC ?: 0; ?></td>
                            <td class="stat dif <?php echo $row->DIF > 0 ? 'plus' : ($row->DIF < 0 ? 'minus' : ''); ?>">
                                <?php echo ($row->DIF > 0 ? '+' : '') . ($row->DIF ?: 0); ?>
                            </td>
                            <td class="stat pts-total"><?php echo $row->PTS ?: 0; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tab Content: Playoffs -->
<div id="playoffs" class="tab-content">
    <div class="bracket-container">
        <?php if($data['totalTeams'] < 2): ?>
            <div class="empty-state">
                <i class="fas fa-sitemap"></i>
                <p>Se necesitan equipos registrados para generar los Play-offs.</p>
            </div>
        <?php else: ?>
            <div class="bracket-tree">
                
                <!-- Octavos (Only if 16+ teams or at least some Octavos matches exist) -->
                <?php if($data['totalTeams'] >= 16 || !empty($data['bracket']['Octavos'])): ?>
                    <div class="bracket-round">
                        <h5>Octavos de Final</h5>
                        <div class="bracket-matches">
                            <?php for($i=0; $i<8; $i++): ?>
                                <?php $m = $data['bracket']['Octavos'][$i] ?? null; ?>
                                <div class="bracket-match-box">
                                    <div class="b-slot <?php echo ($m && $m->puntos_local > $m->puntos_visitante) ? 'winner' : ''; ?>">
                                        <span class="b-name">
                                            <?php if($m && $m->puntos_local > $m->puntos_visitante): ?><i class="fas fa-crown winner-icon"></i><?php endif; ?>
                                            <?php echo $m->equipo_local ?? 'TBD'; ?>
                                        </span>
                                        <span class="b-score"><?php echo $m->puntos_local ?? '-'; ?></span>
                                    </div>
                                    <div class="b-slot <?php echo ($m && $m->puntos_visitante > $m->puntos_local) ? 'winner' : ''; ?>">
                                        <span class="b-name">
                                            <?php if($m && $m->puntos_visitante > $m->puntos_local): ?><i class="fas fa-crown winner-icon"></i><?php endif; ?>
                                            <?php echo $m->equipo_visitante ?? 'TBD'; ?>
                                        </span>
                                        <span class="b-score"><?php echo $m->puntos_visitante ?? '-'; ?></span>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Cuartos -->
                <div class="bracket-round">
                    <h5>Cuartos de Final</h5>
                    <div class="bracket-matches">
                        <?php for($i=0; $i<4; $i++): ?>
                            <?php $m = $data['bracket']['Cuartos'][$i] ?? null; ?>
                            <div class="bracket-match-box">
                                <div class="b-slot <?php echo ($m && $m->puntos_local > $m->puntos_visitante) ? 'winner' : ''; ?>">
                                    <span class="b-name">
                                        <?php if($m && $m->puntos_local > $m->puntos_visitante): ?><i class="fas fa-crown winner-icon"></i><?php endif; ?>
                                        <?php echo $m->equipo_local ?? 'TBD'; ?>
                                    </span>
                                    <span class="b-score"><?php echo $m->puntos_local ?? '-'; ?></span>
                                </div>
                                <div class="b-slot <?php echo ($m && $m->puntos_visitante > $m->puntos_local) ? 'winner' : ''; ?>">
                                    <span class="b-name">
                                        <?php if($m && $m->puntos_visitante > $m->puntos_local): ?><i class="fas fa-crown winner-icon"></i><?php endif; ?>
                                        <?php echo $m->equipo_visitante ?? 'TBD'; ?>
                                    </span>
                                    <span class="b-score"><?php echo $m->puntos_visitante ?? '-'; ?></span>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Semis -->
                <div class="bracket-round">
                    <h5>Semifinales</h5>
                    <div class="bracket-matches">
                        <?php for($i=0; $i<2; $i++): ?>
                            <?php $m = $data['bracket']['Semis'][$i] ?? null; ?>
                            <div class="bracket-match-box">
                                <div class="b-slot <?php echo ($m && $m->puntos_local > $m->puntos_visitante) ? 'winner' : ''; ?>">
                                    <span class="b-name">
                                        <?php if($m && $m->puntos_local > $m->puntos_visitante): ?><i class="fas fa-crown winner-icon"></i><?php endif; ?>
                                        <?php echo $m->equipo_local ?? 'TBD'; ?>
                                    </span>
                                    <span class="b-score"><?php echo $m->puntos_local ?? '-'; ?></span>
                                </div>
                                <div class="b-slot <?php echo ($m && $m->puntos_visitante > $m->puntos_local) ? 'winner' : ''; ?>">
                                    <span class="b-name">
                                        <?php if($m && $m->puntos_visitante > $m->puntos_local): ?><i class="fas fa-crown winner-icon"></i><?php endif; ?>
                                        <?php echo $m->equipo_visitante ?? 'TBD'; ?>
                                    </span>
                                    <span class="b-score"><?php echo $m->puntos_visitante ?? '-'; ?></span>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Final -->
                <div class="bracket-round">
                    <h5>Gran Final</h5>
                    <div class="bracket-matches">
                        <?php $m = $data['bracket']['Final'][0] ?? null; ?>
                        <div class="bracket-match-box final-box">
                            <div class="b-slot <?php echo ($m && $m->puntos_local > $m->puntos_visitante) ? 'winner' : ''; ?>">
                                <span class="b-name">
                                    <?php if($m && $m->puntos_local > $m->puntos_visitante): ?><i class="fas fa-crown winner-icon"></i><?php endif; ?>
                                    <?php echo $m->equipo_local ?? 'TBD'; ?>
                                </span>
                                <span class="b-score"><?php echo $m->puntos_local ?? '-'; ?></span>
                            </div>
                            <div class="b-slot <?php echo ($m && $m->puntos_visitante > $m->puntos_local) ? 'winner' : ''; ?>">
                                <span class="b-name">
                                    <?php if($m && $m->puntos_visitante > $m->puntos_local): ?><i class="fas fa-crown winner-icon"></i><?php endif; ?>
                                    <?php echo $m->equipo_visitante ?? 'TBD'; ?>
                                </span>
                                <span class="b-score"><?php echo $m->puntos_visitante ?? '-'; ?></span>
                            </div>
                        </div>
                        <?php if($m && strtolower($m->estado) == 'finalizado'): ?>
                            <div class="champion-badge">
                                <i class="fas fa-crown"></i>
                                <div class="champ-name"><?php echo ($m->puntos_local > $m->puntos_visitante) ? $m->equipo_local : $m->equipo_visitante; ?></div>
                                <div class="champ-label">CAMPEÓN</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) { tabcontent[i].classList.remove("active"); }
    tablinks = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tablinks.length; i++) { tablinks[i].classList.remove("active"); }
    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
}
</script>

<style>
    .page-header { margin-bottom: 30px; }
    .page-header h1 i { color: var(--primary); margin-right: 15px; }
    
    .stats-tabs { display: flex; gap: 10px; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px; }
    .tab-btn { background: none; border: none; color: var(--text-muted); padding: 12px 25px; font-weight: 600; cursor: pointer; border-radius: 8px; transition: 0.3s; }
    .tab-btn.active { background: var(--primary); color: white; }
    .tab-content { display: none; }
    .tab-content.active { display: block; animation: fadeIn 0.5s ease; }
    
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .stats-container { background: var(--surface); border-radius: 16px; padding: 25px; border: 1px solid rgba(255,255,255,0.05); }
    .standings-table { width: 100%; border-collapse: collapse; }
    .standings-table th { padding: 15px; font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; border-bottom: 2px solid rgba(255,255,255,0.05); }
    .standings-table td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.03); }
    .team-info { display: flex; align-items: center; gap: 10px; }
    .team-icon { width: 28px; height: 28px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 0.7rem; }
    .stat { text-align: center; font-weight: 600; }
    .pts-total { color: var(--primary); font-weight: 800; font-size: 1.1rem; }
    .plus { color: var(--success); }
    .minus { color: var(--danger); }

    /* Bracket Tree Styles */
    .bracket-container { overflow-x: auto; padding: 20px 0; }
    .bracket-tree { display: flex; justify-content: space-between; min-width: 1000px; gap: 30px; padding: 20px; }
    .bracket-round { flex: 1; display: flex; flex-direction: column; }
    .bracket-round h5 { text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 30px; }
    .bracket-matches { flex: 1; display: flex; flex-direction: column; justify-content: space-around; gap: 15px; }
    
    .bracket-match-box { background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden; }
    .b-slot { display: flex; justify-content: space-between; padding: 10px 15px; border-bottom: 1px solid rgba(255,255,255,0.03); }
    .b-slot:last-child { border-bottom: none; }
    .b-name { font-size: 0.85rem; font-weight: 500; color: var(--text-muted); }
    .b-score { font-weight: 800; color: var(--primary); font-size: 0.9rem; }
    
    .b-slot.winner { background: rgba(244, 121, 32, 0.05); }
    .b-slot.winner .b-name { color: white; font-weight: 700; }
    
    .winner-icon {
        color: var(--primary);
        font-size: 0.7rem;
        margin-right: 8px;
        filter: drop-shadow(0 0 5px rgba(244, 121, 32, 0.5));
    }

    .champion-badge { margin-top: 40px; text-align: center; padding: 20px; background: rgba(244, 121, 32, 0.1); border-radius: 16px; border: 1px solid var(--primary); animation: pulse 2s infinite; }
    .champion-badge i { font-size: 2.5rem; color: var(--primary); margin-bottom: 10px; }
    .champ-name { font-size: 1.4rem; font-weight: 800; color: white; margin-bottom: 5px; }
    .champ-label { font-size: 0.7rem; letter-spacing: 3px; color: var(--primary); font-weight: 700; }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(244, 121, 32, 0.4); }
        70% { box-shadow: 0 0 0 15px rgba(244, 121, 32, 0); }
        100% { box-shadow: 0 0 0 0 rgba(244, 121, 32, 0); }
    }

    @media (max-width: 768px) {
        .pf, .pc, .dif { display: none; }
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
