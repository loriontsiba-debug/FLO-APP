<?php

require_once 'db.php';

function tableExists(PDO $connexion, string $table): bool
{
    $statement = $connexion->prepare(
        'SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?'
    );
    $statement->execute([$table]);

    return (bool) $statement->fetchColumn();
}

// Récupération de l'utilisateur (ID 1 pour l'exemple)
$user = null;
if (tableExists($connexion, 'users')) {
    $stmt = $connexion->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([1]);
    $user = $stmt->fetch();
}

// Récupération des logs du jour
$log = null;
if (tableExists($connexion, 'daily_logs')) {
    $stmtLog = $connexion->prepare("SELECT * FROM daily_logs WHERE user_id = ? ORDER BY log_date DESC LIMIT 1");
    $stmtLog->execute([1]);
    $log = $stmtLog->fetch();
}

// Récupération de l'historique des cycles
$history = [];
if (tableExists($connexion, 'cycle_history')) {
    $stmtHistory = $connexion->prepare("SELECT * FROM cycle_history WHERE user_id = ?");
    $stmtHistory->execute([1]);
    $history = $stmtHistory->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flo. - Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo">
                <h2>Flo.</h2>
                <p>suivi du cycle</p>
            </div>

            <div class="cycle-status-widget">
                <span>Jour du cycle</span>
                <div class="day-count">
                    <strong id="sidebar-cycle-day">-</strong> / <span id="sidebar-total-days">-</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="sidebar-progress-fill" style="width: 0%;"></div>
                </div>
            </div>

            <nav class="nav-menu">
                <a href="#" class="nav-item active">Tableau de bord</a>
                <a href="#" class="nav-item">Calendrier</a>
                <a href="#" class="nav-item"> Journal quotidien</a>
                <a href="#" class="nav-item"> Articles</a>
                <a href="#" class="nav-item"> Mon profil</a>
            </nav>

            <div class="sidebar-footer">
                <a href="#" class="back-link">← Retour au site</a>
                <div class="user-profile">
                    <div class="avatar"></div>
                    <div class="user-info">
                        <strong id="sidebar-user-name">-</strong>
                        <small id="sidebar-user-phase">-</small>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header Section -->
            <section class="top-row">
                <div class="card phase-card">
                    <div class="cycle-circle">
                        <span class="circle-number" id="circle-day">-</span>
                        <span class="circle-label">j. cycle</span>
                    </div>
                    <div class="phase-info">
                        <small>BONJOUR, <span id="user-firstname">-</span></small>
                        <h2>Phase <em id="current-phase">-</em></h2>
                        <div class="dates">
                            <p>Prochaines règles : <strong id="next-period-date">-</strong></p>
                            <p>Fenêtre fertile : <strong id="fertile-window">-</strong></p>
                        </div>
                    </div>
                </div>

                <div class="card log-card">
                    <h3>Suivi d'aujourd'hui</h3>
                    <div class="log-grid">
                        <div class="log-item">
                            <span> Humeur</span>
                            <strong id="log-mood">-</strong>
                        </div>
                        <div class="log-item">
                            <span> Sommeil</span>
                            <strong id="log-sleep">-</strong>
                        </div>
                        <div class="log-item">
                            <span> Énergie</span>
                            <strong id="log-energy">-</strong>
                        </div>
                        <div class="log-item">
                            <span> Douleurs</span>
                            <strong id="log-pain">-</strong>
                        </div>
                    </div>
                    <button class="btn-add" id="openLogModal">+ Ajouter une entrée</button>
                </div>
            </section>

            <!-- Metrics Section -->
            <section class="metrics-row">
                <div class="card metric">
                    <small>DURÉE DU CYCLE</small>
                    <div class="metric-value" id="metric-cycle-days">-</div>
                    <small class="sub">Moy. <span id="metric-avg-cycle">-</span> j.</small>
                </div>
                <div class="card metric">
                    <small>DURÉE DES RÈGLES</small>
                    <div class="metric-value pink" id="metric-period-duration">-</div>
                    <small class="sub" id="metric-last-period-range">-</small>
                </div>
                <div class="card metric">
                    <small>RÉGULARITÉ</small>
                    <div class="metric-value green" id="metric-regularity">-</div>
                    <small class="sub">Régulier</small>
                </div>
                <div class="card metric">
                    <small>CYCLES ENREGISTRÉS</small>
                    <div class="metric-value purple" id="metric-registered-cycles">-</div>
                    <small class="sub">Depuis <span id="metric-started-since">-</span></small>
                </div>
            </section>

            <!-- Cycle History Section -->
            <section class="card history-section">
                <h3>Historique des cycles</h3>
                <div class="bar-chart" id="bar-chart-container">
                    <!-- Généré dynamiquement en JS -->
                </div>
            </section>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
<!--$_COOKIE<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Flo. - Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app-container">
        
        <aside class="sidebar">
            <div class="logo">
                <h2>Flo.</h2>
                <span>suivi du cycle</span>
            </div>
            
            <div class="sidebar-widget">
                <p>Jour du cycle <strong>—</strong> / —</p>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: 0%;"></div>
                </div>
            </div>

            <nav class="menu">
                <a href="#" class="active">Tableau de bord</a>
                <a href="#">Calendrier</a>
                <a href="#">Journal quotidien</a>
                <a href="#">Articles</a>
                <a href="#">Mon profil</a>
            </nav>

            <div class="user-profile-bottom">
                <a href="#" class="back-link">← Retour au site</a>
                <div class="user-info">
                    <strong>—</strong>
                    <span class="phase">Aucune donnée</span>
                </div>
            </div>
        </aside>

       Main Content 
        <main class="main-content">
             Header Banner 
            <section class="banner-card">
                <div class="circle-indicator">
                    <span class="day-number">—</span>
                    <span class="day-label">j. cycle</span>
                </div>
                <div class="banner-text">
                    <span class="greeting">BONJOUR</span>
                    <h1>Aucun cycle en cours</h1>
                    <p>Prochaines règles : <strong>—</strong></p>
                    <p>Fenêtre fertile : <strong>—</strong></p>
                </div>
            </section>

             Suivi d'aujourd'hui
            <section class="today-tracking-card">
                <h2>Suivi d'aujourd'hui</h2>
                <div class="tracking-grid">
                    <div class="track-item">
                        <span class="label">Humeur</span>
                        <span class="value">—</span>
                    </div>
                    <div class="track-item">
                        <span class="label">Sommeil</span>
                        <span class="value">—</span>
                    </div>
                    <div class="track-item">
                        <span class="label">Énergie</span>
                        <span class="value">—</span>
                    </div>
                    <div class="track-item">
                        <span class="label">Douleurs</span>
                        <span class="value">—</span>
                    </div>
                </div>
                <button class="btn-primary">+ Ajouter une entrée</button>
            </section>

             Stats Cards 
            <section class="stats-row">
                <div class="stat-card">
                    <h3>DURÉE DU CYCLE</h3>
                    <p class="stat-value">— j</p>
                    <span class="stat-sub">Moy. — j.</span>
                </div>
                <div class="stat-card">
                    <h3>DURÉE DES RÈGLES</h3>
                    <p class="stat-value">— j</p>
                    <span class="stat-sub">Aucune donnée</span>
                </div>
                <div class="stat-card">
                    <h3>RÉGULARITÉ</h3>
                    <p class="stat-value">— %</p>
                    <span class="stat-sub">—</span>
                </div>
                <div class="stat-card">
                    <h3>CYCLES ENREGISTRÉS</h3>
                    <p class="stat-value">0</p>
                    <span class="stat-sub">Aucun cycle</span>
                </div>
            </section>

            Historique des cycles 
            <section class="history-card">
                <h2>Historique des cycles</h2>
                <div class="empty-state">
                    <p>Aucun cycle enregistré pour le moment.</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>-->