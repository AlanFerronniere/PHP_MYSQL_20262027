<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exemple simple</title>
</head>
<body>
<!--kjh-->
<h1>Exemple simple : la date</h1>
Nous sommes le : <?php
date_default_timezone_set("Europe/Paris");
echo "<b>".date('d/m/Y H:i:s')."</b><br>";

$heure = date('H');
if($heure < 12){
    echo "C'est le matin";
}
elseif($heure >= 12 && $heure < 18){
    echo "C'est l'après midi";
}
else{
    echo "Il est tard";
}

?>
</body>
</html>