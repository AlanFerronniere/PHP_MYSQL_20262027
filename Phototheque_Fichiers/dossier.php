<?php
//Je récupère le paramètre dossier de l'url (dossier.php?dossier=xxx)
//$dossierDonneEnParamètre = $_GET["dossier"]; //pas sécurisé
$dossierDonneEnParamètre = filter_input(INPUT_GET, "dossier", FILTER_SANITIZE_SPECIAL_CHARS);
//vérifier si le dossier existe
if ($dossierDonneEnParamètre == ""
        || strpos($dossierDonneEnParamètre, "/") !== false
        || strpos($dossierDonneEnParamètre, "\\") !== false
        || !is_dir("Photos/$dossierDonneEnParamètre")) {
    http_response_code(404);
    echo "Le dossier n'existe pas";
    exit; //pour ne pas executer le reste du code
}

$title = $dossierDonneEnParamètre;
include("header.php");
?>
    <h1><?php echo htmlentities($dossierDonneEnParamètre) ?></h1>
    <div class="row">
        <?php
        //maintenant affichons les photos
        $chemin = "Photos/$dossierDonneEnParamètre/";
        $fichiers = scandir($chemin);
        foreach ($fichiers as $fichier) {
            if ($fichier != "." && $fichier != ".." && is_file($chemin . $fichier)) {
                echo "<div class='col-3'><img class='img-fluid' src='" . $chemin . $fichier . "' alt='" . $fichier . "'></div>";
            }
        }
        ?>
    </div>
    <h2>Ajouter un chaton</h2>
    <!--Pour pouvoir envoyer un fichier j'ajoute enctype="multipart/form-data"-->
    <form action="actions/ajouterChaton.php" method="post" enctype="multipart/form-data">
        Ajoutez un chaton : <input type="file" required name="fichier">
        <br>
        <input type="hidden" name="nomDuDossier" value="<?php echo $dossierDonneEnParamètre ?>">
        <input type="submit" value="OK">
    </form>
<?php
include("footer.php");

