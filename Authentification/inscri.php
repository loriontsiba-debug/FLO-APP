<?php

$nom = "";
$prenom = "";
$email = "";
$passe = "";

$erreurNom = "";
$erreurPrenom = "";
$erreurEmail = "";
$erreurPasse = "";
$erreurPassee = "";

require 'conec_data.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = htmlspecialchars(trim($_POST["nom"]));
    $prenom = htmlspecialchars(trim($_POST["prenom"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $passe = trim($_POST["passe"]);
    $passee = trim($_POST["passee"]);

         // Nom
    if (empty($nom)) {
        $erreurNom = "Veuillez saisir votre nom.";
    }

    // Prénom
    if (empty($prenom)) {
        $erreurPrenom = "Veuillez saisir votre prénom.";
    }

    // Email
    if (empty($email)) {
        $erreurEmail = "Veuillez saisir votre email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurEmail = "Email invalide.";
    }

    // Mot de passe
    if (empty($passe)) {
        $erreurPasse = "Veuillez saisir un mot de passe.";
    } elseif (strlen($passe) < 8) {
        $erreurPasse = "Le mot de passe doit contenir au moins 8 caractères.";
    }

   
    // Confirmation
    if (empty($passee)) {
        $erreurPassee = "Veuillez confirmer le mot de passe.";
    } elseif ($passe != $passee) {
        $erreurPassee = "Les mots de passe ne correspondent pas.";
    }
}

    if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['passe'], $_POST['passee'])) {

    $nom = htmlspecialchars(trim($_POST["nom"]));
    $prenom = htmlspecialchars(trim($_POST["prenom"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $passe = trim($_POST["passe"]);
    $passee = trim($_POST["passee"]);
    if (
    empty($erreurNom) &&
    empty($erreurPrenom) &&
    empty($erreurEmail) &&
    empty($erreurPasse) &&
    empty($erreurPassee)
     ) {
        $requete = $connexion->prepare("SELECT * FROM users WHERE email = :email");
        $requete->execute([
            ':email' => $email
        ]);
        if ($requete->fetch()) {
        $erreurEmail = "Cette adresse e-mail est déjà utilisée.";

        }
         else {
              $hashedPassword = password_hash($passe, PASSWORD_DEFAULT);

              $requete = $connexion->prepare("INSERT INTO users (nom, prenom, email, password)VALUES (:nom, :prenom, :email, :password)");
        $requete->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);
              
        
            header("Location: ../home.php");
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
    <link rel="stylesheet" href="inscri.css">
</head>
<body>
    <div class="contenair">
        <form action="" method="POST">
            <h1>Bienvenue</h1>
             <div class="nom">
                 <span class="erreur">
                <?php echo $erreurNom; ?>
                </span>
                <input type="text" name="nom"  id="nom"  placeholder="nom"value="<?php echo $nom; ?>" 
                class="<?php
                if($erreurNom != ""){
                                  echo "input-erreur";
                                   }
                ?>">
            </div>
            <div class="pre">
                 <span class="erreur">
                <?php echo $erreurPrenom; ?>
                </span>
                <input type="text" name="prenom"  id="prenom" placeholder="prenom" value="<?php echo $prenom; ?>"
                 class="<?php
                if($erreurPrenom != ""){
                                  echo "input-erreur";
                                   }
                ?>"> 
            </div>
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
             <div class="confp">
                  <span class="erreur">
                <?php echo $erreurPassee; ?>
                </span>
                <input type="password" name="passee" id="passee" placeholder="confirmer le mot de passe" 
                 class="<?php
                if($erreurPassee != ""){
                                  echo "input-erreur";
                                   }
                ?>">
            </div>
            <div>
                <input type="submit" value="s'inscrire">
            </div>
            <a href="connec.php">J'ai déjà un compte</a>
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
            <div class="glass glass11"></div>
            <div class="glass glass12"></div>
            <div class="glass glass13"></div>
            <div class="glass glass14"></div>
            <div class="glass glass15"></div>
            <div class="glass glass16"></div>
            <div class="glass glass17"></div>
            <div class="glass glass18"></div>
    </div>
</body>
</html> 