<?php
session_start();

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$token = filter_input(INPUT_POST, "token", FILTER_SANITIZE_SPECIAL_CHARS);

// Si le token reçu ne correspond pas à celui qu'on a dans la session
if (empty($_SESSION["token"]) || $token !== $_SESSION["token"]) {
    die("Vilain pirate 😎");
}

if (!$id) {
    die("Chaton invalide");
}

include_once "../Config.php";
$db = new PDO('mysql:host=' . Config::HOST . ';dbname=' . Config::DBNAME, Config::USER, Config::PASSWORD);

// Récupérer le chaton pour connaître sa photo et sa catégorie
$reqSelect = $db->prepare("SELECT urlPhoto, idCategorie FROM chatons WHERE id = :id");
$reqSelect->bindParam(":id", $id, PDO::PARAM_INT);
$reqSelect->execute();
$chaton = $reqSelect->fetch();

if (!$chaton) {
    header("location: ../index.php");
    exit;
}

$chemin = "../" . $chaton["urlPhoto"];
if (is_file($chemin)) {
    unlink($chemin);
}

$reqDelete = $db->prepare("DELETE FROM chatons WHERE id = :id");
$reqDelete->bindParam(":id", $id, PDO::PARAM_INT);
$reqDelete->execute();

header("location: ../categorie.php?id=" . $chaton["idCategorie"]);
