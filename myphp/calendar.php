<?php
require_once 'db.php';
session_start();

$currentUserId = (int) ($_SESSION['id'] ?? 0);
if ($currentUserId < 1) {
    header('Location: ../Authentification/connec.php');
    exit;
}

$stmt = $connexion->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$currentUserId]);
$user = $stmt->fetch();

$hasCycleData = !empty($user['cycle_start_date']);
$nextPeriodStart = '';
$nextPeriodEnd = '';
$fertileStart = '';
$fertileEnd = '';

if ($hasCycleData) {
    $cycleStart = new DateTime($user['cycle_start_date']);
    $nextPeriod = (clone $cycleStart)->modify('+' . (int) ($user['total_cycle_days'] ?? 28) . ' days');
    $nextPeriodStart = $nextPeriod->format('Y-m-d');
    $nextPeriodEnd = (clone $nextPeriod)->modify('+' . ((int) ($user['period_duration'] ?? 5) - 1) . ' days')->format('Y-m-d');
    $fertileStart = (clone $nextPeriod)->modify('-19 days')->format('Y-m-d');
    $fertileEnd = (clone $nextPeriod)->modify('-14 days')->format('Y-m-d');
}

$calendarData = [
    'name' => $user['name'] ?? trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?: 'Utilisateur',
    'cycleDay' => $hasCycleData ? (int) ($user['cycle_day'] ?? 1) : 0,
    'totalCycleDays' => $hasCycleData ? (int) ($user['total_cycle_days'] ?? 28) : 0,
    'cycleStartDate' => $hasCycleData ? $user['cycle_start_date'] : '',
    'periodDuration' => $hasCycleData ? (int) ($user['period_duration'] ?? 5) : 0,
    'nextPeriodStart' => $nextPeriodStart,
    'nextPeriodEnd' => $nextPeriodEnd,
    'fertileStart' => $fertileStart,
    'fertileEnd' => $fertileEnd,
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flo. - Calendrier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="calendar-page">
    <div class="dashboard-page">
        <header class="topbar">
            <a class="brand" href="dashboard.php">Flo<span>.</span></a>
            <button class="burger" id="burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            <nav class="top-nav" id="menu" aria-label="Navigation principale">
                <a href="dashboard.php">Tableau de bord</a>
                <a class="active" href="calendar.php">Calendrier</a>
                <a href="journal.php">Journal</a>
                <a href="../articles/index.php">Articles</a>
            </nav>
            <div class="account-area">
                <span class="account-avatar" aria-hidden="true">●</span>
                <strong><?= htmlspecialchars($calendarData['name']) ?></strong>
                <a class="logout-button" href="../index.html">Se déconnecter</a>
            </div>
        </header>

        <main class="calendar-main">
            <div class="calendar-page-heading">
                <small class="eyebrow">VOTRE SUIVI</small>
                <h1>Calendrier du cycle</h1>
                <p>Retrouvez vos règles, votre période fertile et votre jour d'ovulation.</p>
            </div>

            <?php if (!$hasCycleData): ?>
                <section class="empty-cycle-card">
                    <div class="empty-cycle-icon">♡</div>
                    <div>
                        <small class="eyebrow">AUCUN CYCLE ENREGISTRÉ</small>
                        <h2>Commencez votre calendrier</h2>
                        <p>Remplissez vos informations pour afficher les dates de vos règles et de votre période fertile.</p>
                    </div>
                    <a class="primary-action" href="cycle-form.php">Remplir le formulaire</a>
                </section>
            <?php else: ?>
                <section class="card cycle-calendar-section standalone-calendar" id="calendar">
                    <div class="calendar-heading">
                        <div>
                            <small class="eyebrow">MON CALENDRIER</small>
                            <h2>Cycle et règles</h2>
                        </div>
                        <div class="calendar-legend">
                            <span><i class="legend-period"></i>Règles enregistrées</span>
                            <span><i class="legend-next-period"></i>Prochaines règles</span>
                            <span><i class="legend-fertile"></i>Période fertile</span>
                            <span><i class="legend-ovulation"></i>Ovulation</span>
                            <span><i class="legend-today"></i>Aujourd'hui</span>
                            <span><i class="legend-cycle"></i>Jour du cycle</span>
                        </div>
                    </div>
                    <div class="calendar-toolbar">
                        <button type="button" class="calendar-nav" id="previous-month" aria-label="Mois précédent">‹</button>
                        <h3 id="calendar-month-label">-</h3>
                        <button type="button" class="calendar-nav" id="next-month" aria-label="Mois suivant">›</button>
                    </div>
                    <div class="calendar-weekdays" aria-hidden="true">
                        <span>Lun</span><span>Mar</span><span>Mer</span><span>Jeu</span><span>Ven</span><span>Sam</span><span>Dim</span>
                    </div>
                    <div class="calendar-grid" id="cycle-calendar-grid"></div>
                </section>
            <?php endif; ?>
        </main>
    </div>
    <script>
        window.dashboardData = <?= json_encode($calendarData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    </script>
    <script src="script.js"></script>
</body>
</html>
