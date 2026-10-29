<?php
$fichier = $_FILES['fichier'];
$nomDuDossier=filter_input(INPUT_POST, "nomDuDossier", FILTER_SANITIZE_SPECIAL_CHARS);

//idéalement ici on ferait des vérifications
//dossier existe dans Photos
//que c'est une image
//que l'image n'existe pas déjà (ou un fichier du même nom)

//on déplac ele fichier uploadé dans le dossier physique
move_uploaded_file($fichier['tmp_name'], "../Photos/$nomDuDossier/".$fichier['name']);

//et on retourne à la page du dossier
header('Location: dossier.php?dossier='.$nomDuDossier);