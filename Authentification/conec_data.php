<?php

$serveur = "localhost";
$base = "flo_app";
$utilisateur = "root";
$motdepasse = "";
$port = 3306;

try {
    $connexion = new PDO("mysql:host=$serveur;port=$port;dbname=$base;charset=utf8mb4", $utilisateur, $motdepasse);

    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Erreur de connexion : " . $e->getMessage());
}

?>  
