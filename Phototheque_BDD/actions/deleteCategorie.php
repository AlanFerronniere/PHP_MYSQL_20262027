<?php
session_start();

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$token = filter_input(INPUT_POST, "token", FILTER_SANITIZE_SPECIAL_CHARS);

// Si le token reçu ne correspond pas à celui qu'on a dans la session
if (empty($_SESSION["token"]) || $token !== $_SESSION["token"]) {
    die("Vilain pirate 😎");
}

if (!$id) {
    die("Catégorie invalide");
}

include_once "../Config.php";
$db = new PDO('mysql:host=' . Config::HOST . ';dbname=' . Config::DBNAME, Config::USER, Config::PASSWORD);

// Supprimer d'abord les photos et les chatons liés (clé étrangère idCategorie)
$reqPhotos = $db->prepare("SELECT urlPhoto FROM chatons WHERE idCategorie = :id");
$reqPhotos->bindParam(":id", $id, PDO::PARAM_INT);
$reqPhotos->execute();
foreach ($reqPhotos->fetchAll() as $chaton) {
    $chemin = "../" . $chaton["urlPhoto"];
    if (is_file($chemin)) {
        unlink($chemin);
    }
}

$reqChatons = $db->prepare("DELETE FROM chatons WHERE idCategorie = :id");
$reqChatons->bindParam(":id", $id, PDO::PARAM_INT);
$reqChatons->execute();

// Puis supprimer la catégorie
$req = $db->prepare("DELETE FROM categories WHERE id = :id");
$req->bindParam(":id", $id, PDO::PARAM_INT);
$req->execute();

header("location: ../index.php");
