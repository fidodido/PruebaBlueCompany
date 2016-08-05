<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\DaysForm;

class IndexController extends AbstractActionController {

    public function indexAction() {

        $form = new DaysForm();
        $feriados = $this->getServiceLocator()
                ->get('SessionPersistence')
                ->getFeriados();

        $success = false;
        $errors = array();

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $form->setData($data);
            $form->setInputFilter($form->getInputFilter());

            if ($form->isValid()) {

                $date = new \Application\Model\Date();
                $date->exchangeArray($data);

                $nextBusinessDay = $date->getNextBusinessDay();

                $this->getServiceLocator()
                        ->get('SessionPersistence')
                        ->saveDate($nextBusinessDay);

                $success = true;
            } else {
                $errors = $form->getMessages();
            }

            $this->getResponse()->setContent(json_encode(array(
                'success' => $success,
                'errors' => $errors
            )));

            return $this->response;
        }

        return new ViewModel(array(
            'form' => $form,
            'feriados' => $feriados
        ));
    }

    public function getDatesAction() {

        $dates = $this->getServiceLocator()
                ->get('SessionPersistence')
                ->getDates();



        $this->getResponse()->setContent(json_encode($dates));

        return $this->response;
    }

}
