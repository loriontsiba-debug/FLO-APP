<?php
$email = "";
$passe = "";


$erreurEmail = "";
$erreurPasse = "";

require_once 'conec_data.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = htmlspecialchars(trim($_POST["email"] ?? ""));
    $passe = trim($_POST["passe"] ?? "");

    if (empty($email)) {
        $erreurEmail = "Veuillez saisir votre email.";
        } else if (empty($passe)) {
        $erreurPasse = "Veuillez saisir votre mot de passe.";
        } else {
            $requete = $connexion->prepare("SELECT * FROM users WHERE email = :email");
            $requete->execute([
            ':email' => $email
            ]);

            $user = $requete->fetch();
        if (!$user) {

            $erreurEmail = "Adresse e-mail incorrect.";

        } elseif (!password_verify($passe, $user['password'])) {

            $erreurPasse = " mot de passe incorrect.";

        } else {

            session_start();

            $_SESSION['id'] = $user['id'];
            $_SESSION['nom'] = $user['nom'];

            header("Location: ../accueil.php");
            exit();
        }
    }
}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
    <link rel="stylesheet" href="connec.css">
</head>
<body>
    <div class="contenair">
        <form action="" method="POST">
            <h1>Bienvenue</h1>
              <div class="email">
                     <span class="erreur">
                         <?php echo $erreurEmail; ?>
                     </span> 
                     <input type="email" name="email" id="email" placeholder="email" value="<?php echo $email; ?>"
                            class="<?php
                            if($erreurEmail != ""){
                                                 echo "input-erreur";
                                                  }
                            ?>">
                </div>
                <div class="passe">
                      <span class="erreur">
                      <?php echo $erreurPasse; ?>
                      </span>
                       <input type="password" name="passe" id="passe" placeholder="Mot de passe"
                            class="<?php
                             if($erreurPasse != ""){
                                                    echo "input-erreur";
                                                   }
                       ?>">
                </div>
            <div>
                <input type="submit" value="Se connecter">
            </div>
              <a href="inscri.php">J'ai pas un compte</a>
        </form>
            <div class="glass glass1"></div>
            <div class="glass glass2"></div>
            <div class="glass glass3"></div>
            <div class="glass glass4"></div>
            <div class="glass glass5"></div>
            <div class="glass glass6"></div>
            <div class="glass glass7"></div>
             <div class="glass glass8"></div>
            <div class="glass glass9"></div>
            <div class="glass glass10"></div>
    </div>
</body>
</html> 