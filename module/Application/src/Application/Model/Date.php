<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Date
 *
 * @author raul
 */

namespace Application\Model;

class Date implements \Zend\Stdlib\ArraySerializableInterface {

    private $date;
    private $days;
    // dias feriados
    private $feriados;

    public function __construct() {
        $this->feriados = array(
            '08/08/2016',
            '09/08/2016'
        );
    }

    function getDate() {
        return $this->date;
    }

    function getDays() {
        return $this->days;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setDays($days) {
        $this->days = $days;
    }

    /*
     * Obtener el siguiente dia habil
     * Desde la fecha introducida 
     * más los X días ingresados.
     */

    public function getNextBusinessDay() {


        // primero es sumarle a la fecha introducida los dias ingresados.
        $date = \DateTime::createFromFormat('d/m/Y', $this->date);

        // sumarle x dias.
        $date->modify('+' . $this->days . 'day');

        // Mientras el dia no sea habil.
        while ($this->isNotBusinessDay($date)) {

            // le sumamos un dia.
            $date->modify('+ 1 day');
        }

        return $date;
    }

    /*
     * Checkea que la fecha NO sea un dia habil
     */

    public function isNotBusinessDay($date) {

        $day = $date->format('D');

        return $day == "Sat" || $day == "Sun" || $this->isFeriado($date);
    }

    public function isFeriado($date) {

        $dateString = $date->format('d/m/Y');

        for ($i = 0; $i < count($this->feriados); $i++) {

            if ($this->feriados[$i] == $dateString) {
                return true;
            }
        }

        return false;
    }

    public function exchangeArray(array $array) {

        $this->date = isset($array['date']) ? $array['date'] : $this->date;
        $this->days = isset($array['numberOfDays']) ? $array['numberOfDays'] : $this->days;
    }

    public function getArrayCopy() {

        return array(
            'date' => $this->date,
            'days' => $this->days
        );
    }

}
