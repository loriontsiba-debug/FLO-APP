<?php

require_once 'db.php';

session_start();

$currentUserId = (int) ($_SESSION['id'] ?? 0);
if ($currentUserId < 1) {
    header('Location: ../Authentification/connec.php');
    exit;
}

function tableExists(PDO $connexion, string $table): bool
{
    $statement = $connexion->prepare(
        'SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?'
    );
    $statement->execute([$table]);

    return (bool) $statement->fetchColumn();
}

function ensureUserTrackingColumns(PDO $connexion): void
{
    if (!tableExists($connexion, 'users')) {
        return;
    }

    $existingColumns = [];
    foreach ($connexion->query('SHOW COLUMNS FROM users') as $column) {
        $existingColumns[$column['Field']] = true;
    }

    $columns = [
        'current_phase' => 'VARCHAR(50) NOT NULL DEFAULT \'Aucune donnée\'',
        'cycle_day' => 'INT NOT NULL DEFAULT 1',
        'total_cycle_days' => 'INT NOT NULL DEFAULT 28',
        'cycle_start_date' => 'DATE NULL',
        'next_period_date' => 'DATE NULL',
        'fertile_window_start' => 'DATE NULL',
        'fertile_window_end' => 'DATE NULL',
        'avg_cycle_length' => 'INT NOT NULL DEFAULT 28',
        'period_duration' => 'INT NOT NULL DEFAULT 5',
        'last_period_range' => 'VARCHAR(50) NULL',
        'regularity' => 'INT NOT NULL DEFAULT 0',
        'registered_cycles' => 'INT NOT NULL DEFAULT 0',
        'started_since' => 'VARCHAR(20) NULL',
    ];

    foreach ($columns as $name => $definition) {
        if (!isset($existingColumns[$name])) {
            $connexion->exec("ALTER TABLE users ADD COLUMN `$name` $definition");
        }
    }
}

ensureUserTrackingColumns($connexion);

$formMessage = '';
$formError = '';

if (($_GET['saved'] ?? '') === '1') {
    $formMessage = 'Votre suivi menstruel a bien été enregistré.';
} elseif (($_GET['saved'] ?? '') === 'log') {
    $formMessage = 'Votre humeur et vos symptômes ont bien été enregistrés.';
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['save_cycle'])) {
    $cycleStartDate = $_POST['cycle_start_date'] ?? '';
    $cycleDay = filter_input(INPUT_POST, 'cycle_day', FILTER_VALIDATE_INT);
    $periodDuration = filter_input(INPUT_POST, 'period_duration', FILTER_VALIDATE_INT);
    $cycleType = $_POST['cycle_type'] ?? '';
    $cycleTypes = [
        'court' => 21,
        'normal' => 28,
        'long' => 35,
    ];

    $validDate = DateTime::createFromFormat('Y-m-d', $cycleStartDate);
    if (!$validDate || $validDate->format('Y-m-d') !== $cycleStartDate) {
        $formError = 'Sélectionnez une date de début valide.';
    } elseif (!$cycleDay || $cycleDay < 1 || $cycleDay > 60) {
        $formError = 'Le jour du cycle doit être compris entre 1 et 60.';
    } elseif (!$periodDuration || $periodDuration < 1 || $periodDuration > 15) {
        $formError = 'La durée des règles doit être comprise entre 1 et 15 jours.';
    } elseif (!isset($cycleTypes[$cycleType])) {
        $formError = 'Sélectionnez une durée de cycle.';
    } elseif (!tableExists($connexion, 'users')) {
        $formError = 'La table des utilisateurs est introuvable.';
    } else {
        $totalCycleDays = $cycleTypes[$cycleType];
        $periodEndDate = (clone $validDate)->modify('+' . ($periodDuration - 1) . ' days');
        $periodRange = $validDate->format('d/m') . ' - ' . $periodEndDate->format('d/m');
        $phase = $cycleDay <= $periodDuration ? 'Règles' : ($cycleDay < $totalCycleDays / 2 ? 'Phase folliculaire' : 'Phase lutéale');

        $stmtCycle = $connexion->prepare(
            'UPDATE users SET cycle_day = ?, total_cycle_days = ?, cycle_start_date = ?, period_duration = ?, last_period_range = ?, current_phase = ? WHERE id = ?'
        );
        $stmtCycle->execute([$cycleDay, $totalCycleDays, $cycleStartDate, $periodDuration, $periodRange, $phase, $currentUserId]);

        if (tableExists($connexion, 'cycle_history')) {
            $stmtHistory = $connexion->prepare(
                'INSERT INTO cycle_history (user_id, month_name, days, is_current) VALUES (?, ?, ?, 1)'
            );
            $stmtHistory->execute([$currentUserId, $validDate->format('M Y'), $totalCycleDays]);
        }

        header('Location: dashboard.php?saved=1');
        exit;
    }
}

// Récupération de l'utilisateur (ID 1 pour l'exemple)
$user = null;
if (tableExists($connexion, 'users')) {
    $stmt = $connexion->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$currentUserId]);
    $user = $stmt->fetch();

    if ($user && empty($user['cycle_start_date']) && !empty($user['last_period_range'])) {
        $rangeParts = [];
        if (preg_match('/^(\d{2})\/(\d{2})\s*-/', $user['last_period_range'], $rangeParts)) {
            $estimatedStartDate = sprintf('%d-%02d-%02d', (int) date('Y'), (int) $rangeParts[2], (int) $rangeParts[1]);
            $stmtBackfill = $connexion->prepare('UPDATE users SET cycle_start_date = ? WHERE id = ?');
            $stmtBackfill->execute([$estimatedStartDate, $currentUserId]);
            $user['cycle_start_date'] = $estimatedStartDate;
        }
    }
}

// Récupération des logs du jour
$log = null;
if (tableExists($connexion, 'daily_logs')) {
    $stmtLog = $connexion->prepare("SELECT * FROM daily_logs WHERE user_id = ? ORDER BY log_date DESC LIMIT 1");
    $stmtLog->execute([$currentUserId]);
    $log = $stmtLog->fetch();
}

$dailyMood = $log['mood'] ?? 'Aucune donnée';
$dailySleep = $log['sleep_hours'] ?? 'Aucune donnée';
$dailyEnergy = $log['energy_level'] ?? 'Aucune donnée';
$dailyPain = $log['pain_level'] ?? 'Aucune donnée';
$dailyAdvice = 'Complétez votre suivi du jour pour recevoir un conseil personnalisé.';
if ($dailyEnergy === 'Basse') {
    $dailyAdvice = 'Accordez-vous une pause, buvez de l’eau et privilégiez une activité douce aujourd’hui.';
} elseif (in_array($dailyMood, ['Triste', 'Irritable'], true)) {
    $dailyAdvice = 'Prenez un moment pour vous : respiration calme, repos et échange avec une personne de confiance peuvent aider.';
} elseif (in_array($dailyPain, ['Crampes', 'Maux de tête'], true)) {
    $dailyAdvice = 'Reposez-vous, hydratez-vous et utilisez une source de chaleur si cela vous soulage.';
} elseif ($dailyEnergy === 'Haute') {
    $dailyAdvice = 'Votre énergie est bonne : profitez-en pour une activité qui vous fait du bien, sans oublier vos pauses.';
}

// Récupération de l'historique des cycles
$history = [];
if (tableExists($connexion, 'cycle_history')) {
    $stmtHistory = $connexion->prepare("SELECT * FROM cycle_history WHERE user_id = ?");
    $stmtHistory->execute([$currentUserId]);
    $history = $stmtHistory->fetchAll();
}

$hasCycleData = !empty($user['last_period_range']);
$nextPeriodDate = '-';
$nextPeriodStart = '';
$nextPeriodEnd = '';
$fertileStart = '';
$fertileEnd = '';
$ovulationDate = '';
if ($hasCycleData && !empty($user['cycle_start_date'])) {
    $nextPeriod = new DateTime($user['cycle_start_date']);
    $nextPeriod->modify('+' . (int) ($user['total_cycle_days'] ?? 28) . ' days');
    $nextPeriodDate = $nextPeriod->format('d/m/Y');
    $nextPeriodStart = $nextPeriod->format('Y-m-d');
    $nextPeriodEndDate = (clone $nextPeriod)->modify('+' . ((int) ($user['period_duration'] ?? 0) - 1) . ' days');
    $nextPeriodEnd = $nextPeriodEndDate->format('Y-m-d');

    $fertileStartDate = (clone $nextPeriod)->modify('-19 days');
    $fertileEndDate = (clone $nextPeriod)->modify('-14 days');
    $fertileStart = $fertileStartDate->format('Y-m-d');
    $fertileEnd = $fertileEndDate->format('Y-m-d');
    $ovulationDate = (clone $nextPeriod)->modify('-16 days')->format('Y-m-d');
}

$dashboardData = [
    'name' => $user['name'] ?? trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?: 'Utilisateur',
    'currentPhase' => $user['current_phase'] ?? 'Aucune donnée',
    'cycleDay' => $hasCycleData ? (int) ($user['cycle_day'] ?? 0) : 0,
    'totalCycleDays' => $hasCycleData ? (int) ($user['total_cycle_days'] ?? 0) : 0,
    'cycleStartDate' => $hasCycleData ? ($user['cycle_start_date'] ?? '') : '',
    'periodDuration' => $hasCycleData ? (int) ($user['period_duration'] ?? 0) : 0,
    'nextPeriodStart' => $nextPeriodStart,
    'nextPeriodEnd' => $nextPeriodEnd,
    'fertileStart' => $fertileStart,
    'fertileEnd' => $fertileEnd,
    'ovulationDate' => $ovulationDate,
    'nextPeriodDate' => $nextPeriodDate,
    'fertileWindow' => '-',
    'avgCycleLength' => (int) ($user['avg_cycle_length'] ?? 0),
    'lastPeriodRange' => $user['last_period_range'] ?? '-',
    'regularity' => (int) ($user['regularity'] ?? 0),
    'registeredCycles' => count($history),
    'startedSince' => $user['started_since'] ?? '-',
    'cycleHistory' => array_map(static function (array $cycle): array {
        return [
            'month' => $cycle['month_name'],
            'days' => (int) $cycle['days'],
            'isCurrent' => (bool) $cycle['is_current'],
        ];
    }, $history),
    'hasCycleData' => $hasCycleData,
    'dailyMood' => $dailyMood,
    'dailySleep' => $dailySleep,
    'dailyEnergy' => $dailyEnergy,
    'dailyPain' => $dailyPain,
    'dailyAdvice' => $dailyAdvice,
];
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
    <div class="dashboard-page">
        <header class="topbar">
            <a class="brand" href="dashboard.php">Flo<span>.</span></a>
            <button class="burger" id="burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav class="top-nav" id="menu" aria-label="Navigation principale">
                <a class="active" href="dashboard.php">Tableau de bord</a>
                <a href="calendar.php">Calendrier</a>
                <a href="journal.php">Journal</a>
                <a href="../articles/index.php">Articles</a>
            </nav>
            <div class="account-area">
                <span class="account-avatar" aria-hidden="true">●</span>
                <strong id="top-user-name">-</strong>
                <button class="notification-button" type="button" aria-label="Notifications">♧</button>
                <a class="logout-button" href="../index.html">Se déconnecter</a>
            </div>
        </header>

        <main class="dashboard-main">
            <?php if ($formMessage || $formError): ?>
                <p id="form-feedback" class="form-feedback <?= $formError ? 'error' : 'success' ?>" role="status">
                    <span class="feedback-icon" aria-hidden="true"><?= $formError ? '!' : '✓' ?></span>
                    <span><?= htmlspecialchars($formMessage ?: $formError) ?></span>
                </p>
            <?php endif; ?>

            <section class="welcome-row">
                <div>
                    <h1>👋 Bonjour <span id="user-firstname">-</span>, bienvenue !</h1>
                    <p id="today-date">Voici votre aperçu du jour</p>
                </div>
                <?php if ($hasCycleData): ?>
                    <a class="dashboard-cycle-button" href="cycle-form.php">Mettre à jour mon cycle</a>
                <?php endif; ?>
            </section>

            <?php if (!$hasCycleData): ?>
                <section class="empty-cycle-card">
                    <div class="empty-cycle-icon">♡</div>
                    <div>
                        <small class="eyebrow">VOTRE ESPACE PERSONNEL</small>
                        <h2>Commencez le suivi de votre cycle</h2>
                        <p>Renseignez la date de vos dernières règles et la durée habituelle de votre cycle pour personnaliser votre dashboard.</p>
                    </div>
                    <a class="primary-action" href="cycle-form.php">Remplir le formulaire</a>
                </section>
            <?php else: ?>

            <section class="dashboard-grid">
                <article class="card cycle-overview">
                    <h2>Vue d'ensemble du jour</h2>
                    <div class="cycle-ring">
                        <div class="cycle-ring-content">
                            <span>Jour du cycle</span>
                            <strong id="circle-day">-</strong>
                        </div>
                    </div>
                    <h3 id="current-phase">-</h3>
                    <p>Prochaines règles<br><strong id="next-period-date">-</strong></p>
                    <a class="primary-action" href="index.php">Ajouter des symptômes</a>
                </article>

                <div class="dashboard-panels">
                    <article class="card symptom-card">
                        <div class="card-heading">
                            <h2>Symptômes &amp; Humeur du jour</h2>
                            <button class="more-button" type="button" aria-label="Plus d'options">...</button>
                        </div>
                        <div class="symptom-list">
                            <div class="symptom selected"><span>☺</span><?= htmlspecialchars($dailyMood) ?></div>
                            <div class="symptom"><span>ϟ</span><?= htmlspecialchars($dailyPain) ?></div>
                            <div class="symptom"><span>☾</span><?= htmlspecialchars($dailySleep) ?></div>
                            <div class="symptom"><span>⚡</span><?= htmlspecialchars($dailyEnergy) ?></div>
                        </div>
                    </article>

                    <article class="card insight-card">
                        <h2>Aujourd'hui, pour vous</h2>
                        <p><?= htmlspecialchars($dailyAdvice) ?></p>
                        <small>Conseil personnalisé à partir de votre suivi du jour.</small>
                    </article>

                    <article class="card water-card">
                        <div class="card-heading"><h2>Suivi de l'eau</h2><span class="card-icon">♧</span></div>
                        <div class="water-progress"><span></span></div>
                        <p>5/8 verres</p>
                    </article>

                    <article class="card sleep-card">
                        <div class="card-heading"><h2>Sommeil</h2><span class="moon-icon">☾</span></div>
                        <strong id="log-sleep"><?= htmlspecialchars($dailySleep) ?></strong>
                    </article>
                </div>
            </section>

            <section class="article-section" id="articles">
                <h2>Sélection d'articles</h2>
                <div class="article-row">
                    <article class="card article-card"><h3>Comment optimiser votre nutrition pendant la phase ovulatoire</h3><p>Repas équilibrés, hydratation et énergie : des conseils simples à appliquer.</p><a href="../articles/article.php?slug=nutrition-cycle">Lire l'article</a></article>
                    <article class="card article-card"><h3>Comprendre vos fluctuations d'énergie</h3><p>Adaptez votre activité, votre repos et vos objectifs aux signaux de votre corps.</p><a href="../articles/article.php?slug=energie-cycle">Lire l'article</a></article>
                    <article class="card article-card"><h3>Soulager les symptômes avec douceur</h3><p>Chaleur, hydratation et mouvement doux pour améliorer votre confort.</p><a href="../articles/article.php?slug=symptomes-regles">Lire l'article</a></article>
                </div>
            </section>
            <?php endif; ?>
        </main>
    </div>

    <script>
        window.dashboardData = <?= json_encode($dashboardData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    </script>
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