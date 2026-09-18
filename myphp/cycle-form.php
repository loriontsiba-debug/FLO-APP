<?php
require_once 'db.php';

session_start();

if (empty($_SESSION['id'])) {
    header('Location: ../Authentification/connec.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flo. - Enregistrer mes règles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="cycle-form-page">
    <main class="cycle-form-shell">
        <a class="back-dashboard" href="dashboard.php">← Retour au dashboard</a>
        <div class="cycle-form-brand">
            <h1>Flo.</h1>
            <p>suivi du cycle</p>
        </div>
        <section class="card cycle-form-welcome">
            <small class="eyebrow">BIENVENUE SUR FLO.</small>
            <h2>Commençons par votre cycle</h2>
            <p>Renseignez ces quelques informations pour personnaliser votre tableau de bord.</p>
            <form method="post" action="dashboard.php" class="cycle-form">
                <div class="form-field">
                    <label for="cycle_start_date">Premier jour des règles</label>
                    <input type="date" id="cycle_start_date" name="cycle_start_date" required>
                </div>
                <div class="form-field">
                    <label for="cycle_day">Jour actuel du cycle</label>
                    <input type="number" id="cycle_day" name="cycle_day" min="1" max="60" placeholder="Ex. 14" required>
                </div>
                <div class="form-field">
                    <label for="period_duration">Durée des règles</label>
                    <div class="input-with-suffix">
                        <input type="number" id="period_duration" name="period_duration" min="1" max="15" placeholder="Ex. 5" required>
                        <span>jours</span>
                    </div>
                </div>
                <div class="form-field">
                    <label for="cycle_type">Durée habituelle du cycle</label>
                    <select id="cycle_type" name="cycle_type" required>
                        <option value="">Choisir une durée</option>
                        <option value="court">Court · environ 21 jours</option>
                        <option value="normal">Normal · environ 28 jours</option>
                        <option value="long">Long · environ 35 jours</option>
                    </select>
                </div>
                <button class="btn-save-cycle" type="submit" name="save_cycle">Enregistrer et voir mon dashboard</button>
            </form>
        </section>
    </main>
</body>
</html>