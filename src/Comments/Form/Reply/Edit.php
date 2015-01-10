<?php

namespace Comments\Form\Reply;
use Comments\Form\Reply;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * form can display errors and valiadte comment input
 * @todo check if controllers want more elements for validation 
 */
class Edit extends Reply {
    
    public function __construct($name = null) {
        parent::__construct();
        $this->add(array(
           'name' => 'id',
           'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'class'=>'reply-id',
            ),
        ));
        $this->inputFilter->add(array(
             'name' => 'reply-id',
             'required' => true,
             'filters' => array(
                    array('name' => 'Int'),
             ),
        ));
        
    }
}