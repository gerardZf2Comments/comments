<?php

namespace Comments\Entity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Description of ModuleComment
 *
 * @author gerard
 */
class CommentHttp extends Comment
{
      /**
     *collection of \ZfModule\Entity\Comment
     * @var Doctrine\Common\Collections\ArrayCollection
     */
    protected $children;
    
    
    protected $http;
    
    /**
     * $this->children = new ArrayCollection;
     * @return \ZfModule\Entity\Comment
     */
    public function __construct() {
        $this->children = new ArrayCollection;
        return $this;
    }

    public function getHttp (){
       return $this->http;
    }
    
    public function setHttp ($http){
        $this->http = $http;
        return $this;
    }    
}
