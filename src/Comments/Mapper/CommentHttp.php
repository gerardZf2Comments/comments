<?php

namespace Comments\Mapper;
use Comments\Mapper\Comment;
use Doctrine\ORM\EntityManager;
use ZfModule\Mapper\Module as Module;

use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * comment mapper uses doctrine
 * @author gerard
 */
class CommentHttp extends Comment
{
    //@todo create abstract getters and setters for these
    protected $relatorField = 'http';
    protected $fKField = 'http';
    protected $entityName = 'Comments\Entity\CommentHttp';
    protected function getRelatorField() {
        return $this->relatorField;
    }
    protected function setRelatorField($rf) {
        return $this->relatorField = $rF;
    }
    protected function getFkField() {
        return $this->fKField;
    }
    protected function setFkField($fk) {
        return $this->fKField = $fk;
    }
    
    
}
