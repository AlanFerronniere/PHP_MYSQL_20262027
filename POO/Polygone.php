<?php

namespace POO;

use http\Exception\InvalidArgumentException;

class Polygone
{
    /**
     * @var array Point[]
     */
    private array $sommets;

    /**
     * @param Point[] $sommets
     */
    public function __construct(array $sommets)
    {
        if (count($sommets) < 3) {
            throw new InvalidArgumentException("Un polygone doit avoir au moins 3 points");
        }

        $this->sommets = $sommets;
    }

    public function calculerPerimetre(): float
    {
        $perimetre = 0.0;
        $n = count($this->sommets);

        for ($i = 0; $i < $n; $i++) {
            $actuel = $this->sommets[$i];
            $suivant = $this->sommets[($i + 1) % $n]; // Revient au point 0 à la fin
            $perimetre += $actuel->calculerDistance($suivant);
        }

        return $perimetre;
    }
}