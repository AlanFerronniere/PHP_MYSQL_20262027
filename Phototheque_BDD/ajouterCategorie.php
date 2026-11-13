<?php
//je démarre les sessions : des données spécifiques à l'utilisateur
session_start();

$title="Ajouter une catégorie";
include "header.php";

//je génère un token
$token = uniqid();
//je le stocke en session (côté serveur donc)
$_SESSION["token"]=$token;
?>
<h1>Ajouter une catégorie à la photothèque</h1>
<form action="actions/creerCategorie.php" method="post">
    <input type="hidden" name="token" value="<?php echo $token ?>">
    Nom : <input name="nom" type="text" maxlength="20" required>
    <br>
    Description :<br>
    <textarea name="description"></textarea>
    <br>
    <input type="submit" value="OK">
</form>

<?php
include "footer.php";