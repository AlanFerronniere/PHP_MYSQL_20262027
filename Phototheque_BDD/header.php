<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Chatons Mignons ❤️</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php
                    //je vais chercher les catégories dans la BDD
                    //1 : connexion à la BDD
                    $db = new PDO('mysql:host=localhost;dbname=alan', 'alan', 'aS3pVBYCOrpi');
                    //2: préparer une requête SQL
                    $req = $db->prepare('SELECT * FROM categories');
                    //3: lancer la requete et récupérer le résultat
                    $req->execute();
                    $categories = $req->fetchAll();

                    //pour débuguer je peux voir ce qu'on a récupéré
                    //var_dump($categories);
                    foreach ($categories as $categorie) {
                        //categorie (au singulier) est un tableau contenant les valeurs de la ligne
                        //dans ["id"] ["nom"] et ["description"]
                        ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                               href="categorie.php?id=<?php echo $categorie["id"] ?>"><?php echo $categorie["nom"] ?></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>