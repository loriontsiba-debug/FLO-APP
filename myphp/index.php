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

$message = '';
$dailyLogsExist = tableExists($connexion, 'daily_logs');

// Traitement de la soumission du formulaire
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $humeur   = trim($_POST['humeur'] ?? '');
    $sommeil  = trim($_POST['sommeil'] ?? '');
    $energie  = trim($_POST['energie'] ?? '');
    $douleurs = trim($_POST['douleurs'] ?? '');
    $date     = date('Y-m-d');

    if (!$dailyLogsExist) {
        $message = "La table daily_logs n'existe pas encore dans la base de données.";
    } elseif (!empty($humeur) && !empty($sommeil) && !empty($energie) && !empty($douleurs)) {
        $stmt = $connexion->prepare(
            'INSERT INTO daily_logs (user_id, log_date, mood, sleep_hours, energy_level, pain_level) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$currentUserId, $date, $humeur, $sommeil, $energie, $douleurs]);
        header('Location: dashboard.php?saved=log');
        exit;
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}

// Récupération du dernier suivi
$dernierSuivi = null;
if ($dailyLogsExist) {
    $stmt = $connexion->prepare("SELECT * FROM daily_logs WHERE user_id = ? ORDER BY log_date DESC, id DESC LIMIT 1");
    $stmt->execute([$currentUserId]);
    $dernierSuivi = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suivi Quotidien</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(45deg, #6d11b8, #ff4b90); padding: 20px; min-height: 100vh; box-sizing: border-box; }
        .back-dashboard { display: inline-block; margin-bottom: 20px; color: #fff; font-weight: bold; text-decoration: none; }
        .back-dashboard:hover { color: #ffd2e2; }
        .container { display: flex; gap: 20px; max-width: 900px; margin: 0 auto; }
        .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-card { width: 300px; flex: 0 1 300px; }
        .dashboard-card { width: 400px; flex: 1 1 400px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        select, input[type="text"] { width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box; }
        button { background: #e05286; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; width: 100%; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 15px; }
        .metric { background: #f9f9f9; padding: 10px; border-radius: 8px; }
        .alert { color: green; font-weight: bold; margin-bottom: 10px; }
        @media (max-width: 700px) {
            body { padding: 16px; }
            .container { display: grid; grid-template-columns: minmax(0, 1fr); gap: 16px; }
            .form-card, .dashboard-card { width: auto; max-width: none; }
        }
    </style>
</head>
<body>

<a class="back-dashboard" href="dashboard.php">← Retour au dashboard</a>

<div class="container">
    <!-- Formulaire de saisie -->
    <div class="card form-card">
        <h3>+ Ajouter une entrée</h3>
        <?php if ($message): ?>
            <p class="alert"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        
        <form method="POST" action="index.php">
            <div class="form-group">
                <label for="humeur">😊 Humeur</label>
                <select name="humeur" id="humeur" required>
                    <option value="Bien">Bien</option>
                    <option value="Très bien">Très bien</option>
                    <option value="Neutre">Neutre</option>
                    <option value="Triste">Triste</option>
                    <option value="Irritable">Irritable</option>
                </select>
            </div>

            <div class="form-group">
                <label for="sommeil">🌙 Sommeil</label>
                <input type="text" name="sommeil" id="sommeil" placeholder="ex: 7h30" required>
            </div>

            <div class="form-group">
                <label for="energie">⚡ Énergie</label>
                <select name="energie" id="energie" required>
                    <option value="Haute">Haute</option>
                    <option value="Moyenne">Moyenne</option>
                    <option value="Basse">Basse</option>
                </select>
            </div>

            <div class="form-group">
                <label for="douleurs">✦ Douleurs</label>
                <select name="douleurs" id="douleurs" required>
                    <option value="Aucune">Aucune</option>
                    <option value="Légères">Légères</option>
                    <option value="Crampes">Crampes</option>
                    <option value="Maux de tête">Maux de tête</option>
                </select>
            </div>

            <button type="submit">Enregistrer</button>
        </form>
    </div>

    <!-- Affichage du Tableau de bord -->
    <div class="card dashboard-card">
        <h3>Suivi d'aujourd'hui</h3>
        
        <?php if ($dernierSuivi): ?>
            <div class="grid">
                <div class="metric">
                    <small>😊 Humeur</small>
                    <p><strong><?= htmlspecialchars($dernierSuivi['humeur']) ?></strong></p>
                </div>
                <div class="metric">
                    <small>🌙 Sommeil</small>
                    <p><strong><?= htmlspecialchars($dernierSuivi['sommeil']) ?></strong></p>
                </div>
                <div class="metric">
                    <small>⚡ Énergie</small>
                    <p><strong><?= htmlspecialchars($dernierSuivi['energie']) ?></strong></p>
                </div>
                <div class="metric">
                    <small>✦ Douleurs</small>
                    <p><strong><?= htmlspecialchars($dernierSuivi['douleurs']) ?></strong></p>
                </div>
            </div>
        <?php else: ?>
            <p>Aucun suivi enregistré pour le moment.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>