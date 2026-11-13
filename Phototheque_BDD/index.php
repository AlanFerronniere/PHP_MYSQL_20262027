<?php
$title = "Accueil de la photothèque";
include("header.php");
?>
<h1>Photothèque de chatons</h1>
<?php
include_once "Config.php";
$db = new PDO('mysql:host=' . Config::HOST . ';dbname=' . Config::DBNAME, Config::USER, Config::PASSWORD);
//je vais chercher les catégories/**/ dans la BDD
//1 : connexion à la BDD

//2: préparer une requête SQL
$req = $db->prepare('SELECT * FROM categories');
//3: lancer la requete et récupérer le résultat
$req->execute();
$categories = $req->fetchAll();
?>
<table class="table table-striped">
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php
    foreach ($categories as $categorie) {
        ?>
        <tr>
            <td><?php echo $categorie["nom"] ?></td>
            <td><?php echo $categorie["description"] ?></td>
            <td>
                <a href="modifierCategorie.php?id=<?php echo $categorie["id"] ?>"
                    class="btn btn-warning">
                    🖍️
                </a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<a href="ajouterCategorie.php" class="btn btn-success mt-3">Ajouter</a>
<?php
include("footer.php");
?>
