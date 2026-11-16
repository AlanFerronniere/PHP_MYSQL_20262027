<?php
session_start();

// Générer un token CSRF et le stocker en session
$token = uniqid();
$_SESSION["token"] = $token;

// Récupérer l'id donné en paramètre
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(404);
    die("Chaton invalide");
}

include_once "Config.php";
$db = new PDO('mysql:host=' . Config::HOST . ';dbname=' . Config::DBNAME, Config::USER, Config::PASSWORD);

$req = $db->prepare('SELECT * FROM chatons WHERE id = :id');
$req->bindParam(":id", $id);
$req->execute();
$chatons = $req->fetchAll();

if (count($chatons) != 1) {
    http_response_code(404);
    die("Pas de chaton pour l'id $id");
}
$chaton = $chatons[0];

$title = "Supprimer un chaton";
include "header.php";
?>
<main class="container mt-4">
    <h1>Supprimer le chaton « <?php echo htmlentities($chaton["nom"]) ?> »</h1>
    <p>Êtes-vous sûr de vouloir supprimer ce chaton ?</p>

    <div class="mb-3">
        <img src="<?php echo htmlentities($chaton["urlPhoto"]) ?>"
             alt="<?php echo htmlentities($chaton["nom"]) ?>"
             style="max-width: 250px;"
             class="img-thumbnail">
    </div>

    <form action="actions/deleteChaton.php" method="post">
        <input type="hidden" name="token" value="<?php echo $token ?>">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input type="submit" value="Confirmer la suppression" class="btn btn-danger">
        <a href="categorie.php?id=<?php echo $chaton["idCategorie"] ?>" class="btn btn-secondary">Annuler</a>
    </form>
</main>
<?php
include "footer.php";
