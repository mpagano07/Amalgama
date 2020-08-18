<?php

require_once('./Unidad.php');

class Piquero implements Unidad
{
    private int $fuerza = 5;

    public function entrenar()
    {
        $this->fuerza += 10;
    }

    public function mostrarUnidad()
    {
        return ['nombre' => 'Piquero', 'fuerza' => $this->fuerza];
    }
}