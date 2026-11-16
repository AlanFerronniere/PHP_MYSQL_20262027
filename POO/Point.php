<?php

namespace POO;

/**
 * Représente un point dans un repère à 2 dimensions
 */
class Point
{
    private string $nom;
    private float $x;
    private float $y;

    /**
     * @param string $unNom nom du point
     * @param float $unX abscisse du point
     * @param float $unY ordonnée du point
     */
    public function __construct(string $unNom, float $unX, float $unY)
    {
        $this->nom = $unNom;
        $this->x = $unX;
        $this->y = $unY;
    }

    public function __toString()
    {
        return "$this->nom($this->x, $this->y)";
    }

    /**
     * Calcule la distance entre 2 points
     * @param Point $autrePoint autre point
     * @return float distance entre les 2
     */
    public function calculerDistance(Point $autrePoint)
    {
        return sqrt(pow($this->x - $autrePoint->x, 2)
            + pow($this->y - $autrePoint->y, 2));
    }
}