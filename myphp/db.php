<?php
$serveur = "localhost";
$db  = 'flo_app';
$user = 'root';
$pass = '25ADrx@';

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$db", $user, $pass);

    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Erreur de connexion : " . $e->getMessage());
}
?>