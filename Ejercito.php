<?php

require_once('./Arquero.php');
require_once('./Piquero.php');
require_once('./Caballero.php');

class Ejercito
{
    private array $composicion = [];
    private int $monedas = 1000;
    private array $historial = [];

    public function __construct($civilizacion)
    {
        $this->crearEjercito($civilizacion);
    }

    private function crearEjercito($civilizacion)
    {
        $piquero = 0;
        $arquero = 0;
        $caballero = 0;

        switch ($civilizacion) {
            case 'chinos':
                $piquero = 2;
                $arquero = 25;
                $caballero = 2;
                break;
            case 'ingleses':
                $piquero = 10;
                $arquero = 10;
                $caballero = 10;
                break;
            case 'bizantinos':
                $piquero = 5;
                $arquero = 8;
                $caballero = 15;
                break;
        }

        while ($piquero > 0) {
            $this->composicion[] = new Piquero();
            $piquero = $piquero - 1;
        }

        while ($arquero > 0) {
            $this->composicion[] = new Arquero();
            $arquero = $arquero - 1;
        }

        while ($caballero > 0) {
            $this->composicion[] = new Caballero();
            $caballero = $caballero - 1;
        }
    }

    public function mostrarComposicion()
    {
        return array_map(function ($unidad) {
            return $unidad->mostrarUnidad();
        }, $this->composicion);
    }

    public function mostrarPuntaje()
    {
        return array_reduce($this->mostrarComposicion(), function($result, $unidad){
            $result = $result + $unidad['fuerza']; 
            return $result;
        });
    }

    public function mostrarMonedas()
    {
        return $this->monedas;
    }

    public function entrenar($posicion)
    {
        $costo = 0;

        switch (get_class($this->composicion[$posicion])) {
            case 'Piquero':
                $costo = 3;
                break;
            case 'Arquero':
                $costo = 7;
                break;
            case 'Caballero':
                $costo = 10;
                break;
        }

        if ($this->mostrarMonedas() < $costo) {
            return false;
        }

        $this->composicion[$posicion]->entrenar();

        $this->monedas -= $costo;

        return true;
    }

    public function transformar($posicion)
    {
        $costo = 0;

        switch (get_class($this->composicion[$posicion])) {
            case 'Piquero':
                $costo = 30;

                if ($this->mostrarMonedas() < $costo) {
                    return false;
                }
                $this->composicion[$posicion] = new Arquero;

                $this->monedas -= $costo;
                break;
            case 'Arquero':
                $costo = 40;

                if ($this->mostrarMonedas() < $costo) {
                    return false;
                }

                $this->composicion[$posicion] = new Caballero;

                $this->monedas -= $costo;
                break;
            case 'Caballero':
                return false;
                break;
        }

        return true;
    }

    public function atacar(Ejercito $enemigo)
    {
        $miPuntaje = $this->mostrarPuntaje();
        $puntajeEnemigo = $enemigo->mostrarPuntaje();

        if($miPuntaje > $puntajeEnemigo){
            $this->gane();
            $enemigo->perdi();
        }elseif($miPuntaje == $puntajeEnemigo){
            $this->empate();
            $enemigo->empate();  
        }else{
            $this->perdi();
            $enemigo->gane();
        }
    }

    public function gane()
    {
        $this->monedas += 100;
        $this->historial[] = 'gane';
    }

    public function perdi()
    {
        $this->removerMayorUnidad();
        $this->removerMayorUnidad();        
        $this->historial[] = 'perdi';
    }

    public function empate()
    {
        array_shift($this->composicion); 
        $this->historial[] = 'empate';
    }

    private function removerMayorUnidad()
    {
        $fuerzas = array_column($this->mostrarComposicion(), 'fuerza');
        $maxFuerza = array_keys($fuerzas, max($fuerzas));
        array_splice($this->composicion, $maxFuerza[0], 1);
    }

    public function historial()
    {
        return $this->historial();
    }
}
