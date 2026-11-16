<?php
include 'Point.php';
include 'Polygone.php';
use POO\Point; //je dis quelle classe je vais utiliser
use POO\Polygone;

//je peux me servir du point
$p1 = new Point("A", 2, 3);
$p2 = new Point("B", 5, 2);
$p3 = new Point("C", 2, 7);

echo $p1;
echo "<br>";
echo $p2;
echo "<br>";
echo "La distance entre les deux est : ".$p1->calculerDistance($p2);

//avec mes 3 points je peux faire un polygone
$poly=new Polygone([$p1,$p2,$p3]);
