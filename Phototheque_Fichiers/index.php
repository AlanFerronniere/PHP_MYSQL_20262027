<?php
$title = "Accueil de la photothèque";
include("header.php");
?>
<h1>Photothèque de chatons</h1>
<h2>Ajouter un dossier à la photothèque</h2>
<form action="actions/creerDossier.php" method="post">
    Nom du dossier : <input name="nomDuDossier" type="text" maxlength="20" required>
    <br>
    <input type="submit" value="OK">
</form>

<?php
include("footer.php");
?>
