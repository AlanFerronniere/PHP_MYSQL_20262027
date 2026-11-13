<?php
session_start();
$nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_SPECIAL_CHARS);
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$token = filter_input(INPUT_POST, "token", FILTER_SANITIZE_SPECIAL_CHARS);

//si le token reçu ne correspond pas à celui qu'on a dans la session
if($token !== $_SESSION["token"]){
    die("Vilain pirate 😎");
}

/*var_dump($nom);
var_dump($description);*/

//je vais chercher les catégories dans la BDD
//1 : connexion à la BDD
include_once "../Config.php";
$db = new PDO('mysql:host='.Config::HOST.';dbname='.Config::DBNAME, Config::USER, Config::PASSWORD);
//2: préparer une requête SQL
$req = $db->prepare("UPDATE categories set nom=:nom, description=:description where id=:id");
$req->bindParam(":nom", $nom);
$req->bindParam(":description", $description);
$req->bindParam(":id", $id);

//3: lancer la requete
$req->execute();

header("location: ../index.php");
