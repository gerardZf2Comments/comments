<?php

namespace Comments\Form\Comment;
use Comments\Form\Comment;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * form can display errors and valiadte comment input
 * @todo check if controllers want more elements for validation 
 */
class Edit extends Comment
{
    public function __construct($name = null) {
        parent::__construct($name);
        $this->add(array(
           'name' => 'id',
           'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'class'=>'comment-id',
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