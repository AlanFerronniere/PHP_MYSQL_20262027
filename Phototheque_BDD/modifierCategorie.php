<?php
//je démarre les sessions : des données spécifiques à l'utilisateur
session_start();

$title="Modifier une catégorie";
include "header.php";

//je génère un token
$token = uniqid();
//je le stocke en session (côté serveur donc)
$_SESSION["token"]=$token;

//récupérer l'id donné en paramètre
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

include_once "Config.php";
$db = new PDO('mysql:host=' . Config::HOST . ';dbname=' . Config::DBNAME, Config::USER, Config::PASSWORD);
//2: préparer une requête SQL
$req = $db->prepare('SELECT * FROM categories where id=:id');
$req->bindParam(":id", $id);
//3: lancer la requete et récupérer le résultat
$req->execute();
$categories = $req->fetchAll();
//normalement quand j'arrive là il devrait y a voir 1 ligne unique dans $categories
if(count($categories)!=1){
    http_response_code(404);
    die("Pas de catégorie pour l'id $id");
}
//sinon c'est bon
$categorie = $categories[0]; //je récupère cette première ligne
?>
<h1>Modifier une catégorie à la photothèque</h1>
<form action="actions/updateCategorie.php" method="post">
    <input type="hidden" name="token" value="<?php echo $token ?>">
    Nom : <input name="nom" type="text" maxlength="20" required value="<?php echo htmlentities($categorie["nom"]) ?>">
    <br>
    Description :<br>
    <textarea name="description"><?php echo htmlentities($categorie["description"]) ?></textarea>
    <br>
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <input type="submit" value="OK">
</form>

<?php
include "footer.php";