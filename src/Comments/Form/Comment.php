<?php

namespace Comments\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * form can display errors and valiadte comment input
 * @todo check if controllers want more elements for validation 
 */
 class Comment extends Form {

     /**
     * the input filter object
     * @var Zend\InputFilter\InputFilter
     */
    protected $inputFilter;
    
    /**
      * set name and instanciate elements and input filter
     * @param string $name
     */
    public function __construct($name = null)
     {

        
        parent::__construct('comment');
        $this->setInputFilter($this->getInputFilter()); 
        $this->add(array(
           'name' => 'id',
           'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'class'=>'comment-id',
            ),
        ));
        $this->add(array(
            'name' => 'module-id',
            'type' => 'Zend\Form\Element\Hidden',
             'attributes' => array(
                'class'=>'module-id'
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Title',
               
            ),
            'attributes' => array(
                'class'=>'element'
            ),
        ));
        $this->add(array(
            'name' => 'comment',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Comment',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Post',
                'id' => 'submitbutton',
            ),
        ));
    }
    /**
     * instanciate, assign then return the filter 
     * @return Zend\InputFilter\InputFilter
     */
    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $inputFilter->add(array(
               'name' => 'module-id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));
            $inputFilter->add(array(
                'name' => 'comment',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 10000,
                        ),
                    ),
                ),
            ));
            $inputFilter->add(array(
                'name' => 'title',
                'required' => true,
                ' filters' => array(
                    array('name' => 'StripTags'),
                    array('name’ => ’StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

}

