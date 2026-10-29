<?php
$nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_SPECIAL_CHARS);
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);

/*var_dump($nom);
var_dump($description);*/

//je vais chercher les catégories dans la BDD
//1 : connexion à la BDD
$db = new PDO('mysql:host=localhost;dbname=alan', 'alan', 'aS3pVBYCOrpi');
//2: préparer une requête SQL
$req = $db->prepare("INSERT INTO categories (nom,description) VALUES (:nom,:description)");
$req->bindParam(":nom", $nom);
$req->bindParam(":description", $description);

//3: lancer la requete
$req->execute();

header("location: ../index.php");
