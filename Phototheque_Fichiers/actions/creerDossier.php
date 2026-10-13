<?php
//on va récupérer les infos envoyées en POST
$nomDuDossier=filter_input(INPUT_POST, "nomDuDossier", FILTER_SANITIZE_SPECIAL_CHARS);

$nomDossier=preg_replace('/[^a-zA-Z0-9\_-]/', '-', $nomDuDossier);

//on crée le dossier s'il n'existe pas déjà
if(!is_dir("../Photos/".$nomDuDossier)){
    mkdir("../Photos/".$nomDuDossier); //mkdir : make directory (c'est la commande linux)
}

//quand on a créé le dossier, on bascule à sa page, comme si on avait cliqué dessus
//dans le menu. On redirige l'internaute.
header("Location:../dossier.php?dossier=".$nomDuDossier);


