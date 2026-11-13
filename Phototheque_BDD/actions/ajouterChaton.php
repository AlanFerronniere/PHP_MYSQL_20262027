<?php
session_start();

$token = filter_input(INPUT_POST, "token", FILTER_SANITIZE_SPECIAL_CHARS);
$idCategorie = filter_input(INPUT_POST, "idCategorie", FILTER_VALIDATE_INT);
$nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_SPECIAL_CHARS);
$age = filter_input(INPUT_POST, "age", FILTER_VALIDATE_INT);

// Si le token reçu ne correspond pas à celui qu'on a dans la session
if (empty($_SESSION["token"]) || $token !== $_SESSION["token"]) {
    die("Vilain pirate 😎");
}

if (!$idCategorie || empty($nom) || $age === false || $age === null || $age < 0) {
    die("Données invalides");
}

// Vérification de l'upload de la photo
if (!isset($_FILES["photo"]) || $_FILES["photo"]["error"] !== UPLOAD_ERR_OK) {
    $codeErreur = $_FILES["photo"]["error"] ?? -1;
    $messagesErreur = [
        UPLOAD_ERR_INI_SIZE => "La photo dépasse la taille maximale autorisée par le serveur (" . ini_get("upload_max_filesize") . ").",
        UPLOAD_ERR_FORM_SIZE => "La photo dépasse la taille maximale autorisée par le formulaire.",
        UPLOAD_ERR_PARTIAL => "La photo n'a été envoyée que partiellement.",
        UPLOAD_ERR_NO_FILE => "Aucun fichier n'a été envoyé.",
        UPLOAD_ERR_NO_TMP_DIR => "Dossier temporaire manquant sur le serveur.",
        UPLOAD_ERR_CANT_WRITE => "Échec de l'écriture du fichier sur le disque.",
        UPLOAD_ERR_EXTENSION => "Envoi bloqué par une extension PHP."
    ];
    $message = $messagesErreur[$codeErreur] ?? "Erreur lors de l'envoi de la photo (code $codeErreur).";
    header("location: ../categorie.php?id=" . $idCategorie . "&erreur=" . urlencode($message));
    exit;
}

$fichier = $_FILES["photo"];

// Vérifier que le fichier est bien une image autorisée
$extensionsAutorisees = [
    "image/jpeg" => "jpg",
    "image/png" => "png",
    "image/gif" => "gif",
    "image/webp" => "webp"
];

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $fichier["tmp_name"]);
finfo_close($finfo);

if (!array_key_exists($mimeType, $extensionsAutorisees)) {
    header("location: ../categorie.php?id=" . $idCategorie . "&erreur=" . urlencode("Le fichier doit être une image (JPG, PNG, GIF ou WEBP)."));
    exit;
}

// Générer un nom de fichier unique pour éviter les collisions
$extension = $extensionsAutorisees[$mimeType];
$nomFichier = uniqid("chaton_", true) . "." . $extension;
$urlPhoto = "Photos/" . $nomFichier;

if (!move_uploaded_file($fichier["tmp_name"], $dossierPhotos . "/" . $nomFichier)) {
    header("location: ../categorie.php?id=" . $idCategorie . "&erreur=" . urlencode("Impossible d'enregistrer la photo."));
    exit;
}

// Enregistrement en BDD
include_once "../Config.php";
$db = new PDO('mysql:host=' . Config::HOST . ';dbname=' . Config::DBNAME, Config::USER, Config::PASSWORD);

$req = $db->prepare("INSERT INTO chatons (nom, age, urlPhoto, idCategorie) VALUES (:nom, :age, :urlPhoto, :idCategorie)");
$req->bindParam(":nom", $nom);
$req->bindParam(":age", $age, PDO::PARAM_INT);
$req->bindParam(":urlPhoto", $urlPhoto);
$req->bindParam(":idCategorie", $idCategorie, PDO::PARAM_INT);
$req->execute();

header("location: ../categorie.php?id=" . $idCategorie);
