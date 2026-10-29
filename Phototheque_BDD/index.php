<?php
$title = "Accueil de la photothèque";
include("header.php");
?>
<h1>Photothèque de chatons</h1>
<h2>Ajouter une catégorie à la photothèque</h2>
<form action="actions/creerCategorie.php" method="post">
    Nom : <input name="nom" type="text" maxlength="20" required>
    <br>
    Description :<br>
    <textarea name="description"></textarea>
    <br>
    <input type="submit" value="OK">
</form>

<?php
include("footer.php");
?>
