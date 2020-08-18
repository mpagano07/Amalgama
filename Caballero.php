<?php

require_once('./Unidad.php');

class Caballero implements Unidad
{
    private int $fuerza = 20;

    public function entrenar()
    {
        $this->fuerza += 30;
    }

    public function mostrarUnidad()
    {
        return ['nombre' => 'Caballero', 'fuerza' => $this->fuerza];
    }
}