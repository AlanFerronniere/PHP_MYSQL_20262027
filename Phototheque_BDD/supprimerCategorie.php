<?php
session_start();

// Générer un token CSRF et le stocker en session
$token = uniqid();
$_SESSION["token"] = $token;

// Récupérer l'id donné en paramètre
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(404);
    die("Catégorie invalide");
}

include_once "Config.php";
$db = new PDO('mysql:host=' . Config::HOST . ';dbname=' . Config::DBNAME, Config::USER, Config::PASSWORD);

$req = $db->prepare('SELECT * FROM categories WHERE id = :id');
$req->bindParam(":id", $id, PDO::PARAM_INT);
$req->execute();
$categories = $req->fetchAll();

if (count($categories) != 1) {
    http_response_code(404);
    die("Pas de catégorie pour l'id $id");
}
$categorie = $categories[0];

// Vérifier s'il y a des chatons associés à cette catégorie
$reqCount = $db->prepare('SELECT COUNT(*) FROM chatons WHERE idCategorie = :id');
$reqCount->bindParam(":id", $id, PDO::PARAM_INT);
$reqCount->execute();
$nbChatons = (int)$reqCount->fetchColumn();

$title = "Supprimer une catégorie";
include "header.php";
?>
<main class="container mt-4">
    <h1>Supprimer la catégorie « <?php echo htmlentities($categorie["nom"]) ?> »</h1>
    <p>Êtes-vous sûr de vouloir supprimer cette catégorie ?</p>

    <?php if ($nbChatons > 0): ?>
        <div class="alert alert-warning">
            Attention : cette catégorie contient <?php echo $nbChatons ?> chaton(s) qui seront également supprimés.
        </div>
    <?php endif; ?>

    <form action="actions/deleteCategorie.php" method="post">
        <input type="hidden" name="token" value="<?php echo $token ?>">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input type="submit" value="Confirmer la suppression" class="btn btn-danger">
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</main>
<?php
include "footer.php";
