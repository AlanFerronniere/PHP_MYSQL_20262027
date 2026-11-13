<?php
session_start();

// Je génère un token CSRF
$token = uniqid();
$_SESSION["token"] = $token;

// Récupérer l'id de la catégorie depuis l'URL
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(404);
    die("Catégorie invalide");
}

include_once "Config.php";
$db = new PDO('mysql:host=' . Config::HOST . ';dbname=' . Config::DBNAME, Config::USER, Config::PASSWORD);

// Récupérer la catégorie
$req = $db->prepare('SELECT * FROM categories WHERE id = :id');
$req->bindParam(":id", $id, PDO::PARAM_INT);
$req->execute();
$categories = $req->fetchAll();

if (count($categories) != 1) {
    http_response_code(404);
    die("Pas de catégorie pour l'id $id");
}
$categorie = $categories[0];

// Récupérer les chatons de cette catégorie
$reqChatons = $db->prepare('SELECT * FROM chatons WHERE idCategorie = :idCategorie');
$reqChatons->bindParam(":idCategorie", $id, PDO::PARAM_INT);
$reqChatons->execute();
$chatons = $reqChatons->fetchAll();

$title = $categorie["nom"];
include "header.php";
?>
<main class="container mt-4">
    <h1><?php echo htmlentities($categorie["nom"]) ?></h1>
    <p><?php echo htmlentities($categorie["description"]) ?></p>

    <?php if (isset($_GET["erreur"])): ?>
        <div class="alert alert-danger">
            <?php echo htmlentities($_GET["erreur"]) ?>
        </div>
    <?php endif; ?>

    <div class="row mt-4">
        <?php if (count($chatons) === 0): ?>
            <p class="text-muted">Aucun chaton dans cette catégorie pour le moment.</p>
        <?php else: ?>
            <?php foreach ($chatons as $chaton): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlentities($chaton["urlPhoto"]) ?>"
                             class="card-img-top"
                             alt="<?php echo htmlentities($chaton["nom"]) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlentities($chaton["nom"]) ?></h5>
                            <p class="card-text">Âge : <?php echo htmlentities($chaton["age"]) ?> an(s)</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <hr class="my-4">

    <h2>Ajouter un chaton</h2>
    <!-- Pour pouvoir envoyer un fichier j'ajoute enctype="multipart/form-data" -->
    <form action="actions/ajouterChaton.php" method="post" enctype="multipart/form-data" class="mb-5">
        <input type="hidden" name="token" value="<?php echo $token ?>">
        <input type="hidden" name="idCategorie" value="<?php echo $id ?>">

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input id="nom" name="nom" type="text" maxlength="20" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Âge</label>
            <input id="age" name="age" type="number" min="0" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input id="photo" type="file" name="photo" accept="image/*" required class="form-control">
        </div>

        <input type="submit" value="Ajouter" class="btn btn-success">
    </form>
</main>
<?php
include "footer.php";
