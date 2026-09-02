<?php

$serveur = "localhost";
$base = "flo_app";
$utilisateur = "root";
$motdepasse = "25ADrx@";

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$base", $utilisateur, $motdepasse);

    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Erreur de connexion : " . $e->getMessage());
}

?>