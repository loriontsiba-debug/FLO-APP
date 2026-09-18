<?php
require_once 'db.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$currentUserId = (int) ($_SESSION['id'] ?? 0);
if ($currentUserId < 1) {
    header('Location: ../Authentification/connec.php');
    exit;
}

$tableCheck = $connexion->query(
    "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'daily_logs'"
);
if (!(bool) $tableCheck->fetchColumn()) {
    $connexion->exec(
        'CREATE TABLE daily_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            log_date DATE NOT NULL,
            mood VARCHAR(50),
            sleep_hours VARCHAR(20),
            energy_level VARCHAR(50),
            pain_level VARCHAR(50),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )'
    );
}

$stmtLogs = $connexion->prepare(
    'SELECT log_date, mood, sleep_hours, energy_level, pain_level FROM daily_logs WHERE user_id = ? ORDER BY log_date DESC, id DESC'
);
$stmtLogs->execute([$currentUserId]);
$logs = $stmtLogs->fetchAll();

$userName = $_SESSION['prenom'] ?? $_SESSION['nom'] ?? 'Utilisateur';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flo. - Journal quotidien</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="journal-page">
    <div class="dashboard-page">
        <header class="topbar">
            <a class="brand" href="dashboard.php">Flo<span>.</span></a>
            <button class="burger" id="burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            <nav class="top-nav" id="menu" aria-label="Navigation principale">
                <a href="dashboard.php">Tableau de bord</a>
                <a href="calendar.php">Calendrier</a>
                <a class="active" href="journal.php">Journal</a>
                <a href="../articles/index.php">Articles</a>
            </nav>
            <div class="account-area">
                <span class="account-avatar" aria-hidden="true">●</span>
                <strong><?= htmlspecialchars($userName) ?></strong>
                <a class="logout-button" href="../index.html">Se déconnecter</a>
            </div>
        </header>

        <main class="journal-main">
            <div class="journal-heading">
                <small class="eyebrow">VOTRE BIEN-ÊTRE</small>
                <h1>Journal quotidien</h1>
                <p>Observez vos habitudes et comprenez progressivement les signaux de votre corps.</p>
                <a class="primary-action journal-action" href="index.php">Ajouter le suivi du jour</a>
            </div>

            <?php if (!$logs): ?>
                <section class="empty-cycle-card journal-empty">
                    <div class="empty-cycle-icon">✦</div>
                    <div>
                        <small class="eyebrow">PREMIÈRE ENTRÉE</small>
                        <h2>Votre journal est encore vide</h2>
                        <p>Notez votre humeur, votre sommeil, votre énergie et vos douleurs pour recevoir des conseils plus personnels.</p>
                    </div>
                    <a class="primary-action" href="index.php">Commencer le suivi</a>
                </section>
            <?php else: ?>
                <section class="journal-history">
                    <?php foreach ($logs as $log): ?>
                        <article class="card journal-entry">
                            <div class="journal-entry-date">
                                <strong><?= htmlspecialchars((new DateTime($log['log_date']))->format('d')) ?></strong>
                                <span><?= htmlspecialchars((new DateTime($log['log_date']))->format('M Y')) ?></span>
                            </div>
                            <div class="journal-entry-values">
                                <div><small>Humeur</small><strong><?= htmlspecialchars($log['mood'] ?: '-') ?></strong></div>
                                <div><small>Énergie</small><strong><?= htmlspecialchars($log['energy_level'] ?: '-') ?></strong></div>
                                <div><small>Sommeil</small><strong><?= htmlspecialchars($log['sleep_hours'] ?: '-') ?></strong></div>
                                <div><small>Symptômes</small><strong><?= htmlspecialchars($log['pain_level'] ?: '-') ?></strong></div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>
