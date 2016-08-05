<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class DaysForm extends Form {

    private $inputFilter;

    public function __construct($name = null) {

        parent::__construct($name);

        $this->add(array(
            'name' => 'date',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Date',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'value' => date('d/m/Y')
            ),
        ));

        $this->add(array(
            'name' => 'numberOfDays',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Number of Days',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));
    }

    public function getInputFilter() {

        if (!$this->inputFilter) {

            $inputFilter = new InputFilter();
            $this->inputFilter = $inputFilter;

            $inputFilter->add(array(
                'name' => 'date',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Date',
                        'options' => array(
                            'format' => 'd/m/Y'
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'numberOfDays',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Digits',
                    ),
                ),
            ));
        }

        return $this->inputFilter;
    }

}
