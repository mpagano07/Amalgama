<?php

require_once('./Unidad.php');

class Arquero implements Unidad
{
    private int $fuerza = 10;

    public function entrenar()
    {
        $this->fuerza += 20;
    }

    public function mostrarUnidad()
    {
        return ['nombre' => 'Arquero', 'fuerza' => $this->fuerza];
    }
}