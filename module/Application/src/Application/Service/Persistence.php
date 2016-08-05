<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Persistence
 *
 * @author raul
 */

namespace Application\Service;

use Application\Model\Date;

/*
 * Peristence en session.
 */

class Persistence {

    private $container;

    const KEY = "dates";

    public function __construct($container) {
        $this->container = $container;
    }

    public function saveDate(\DateTime $date) {

        // Primero obtenemos la data de sesion.
        // Si es la primear vez, guardamos un array.
        if (!isset($this->container->dates)) {
            $this->container->dates = array();
        }


        $this->container->dates[] = $date->format('d/m/Y');
    }

    public function getDates() {

        return array_reverse($this->container->dates);
    }

    public function getFeriados() {

        $date = new Date();
        return $date->getFeriados();
    }

}
