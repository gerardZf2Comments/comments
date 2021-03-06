<?php

namespace Comments\Entity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Description of ModuleComment
 *
 * @author gerard
 */
abstract class Comment 
{

    /**
     * binary
     * @var int
     */
    protected $hasParent;
    /**
     * parent comment entity
     * @var \Comments\Entity\Comment
     */
    protected $parent;
    /**
     *comment tittle not used in replies
     * @var string
     */
    protected $title;
    /**
     *collection of \Comments\Entity\Comment
     * @var Doctrine\Common\Collections\ArrayCollection
     */
   
    protected $replies;
    /**
     * discription
     * @var int
     */
    protected $id;
    /**
     *all comments are related to a module 1-1
     * @var int
     */
    protected $moduleId;
    /**
     *comment must have been made by user 1-1
     * @var \ZfcUserDoctrineORM\Entity\User
     */
    protected $user;
    /**
     *discription
     * @var string
     */
    protected $content;
    /*
     * @var int
     */
    protected $isClosed;
    /**
     *using doctrine datatimes are persisted and retrieved as objects
     * @var \Datetime
     */
    protected $createdAt;
    /**
     * $this->children = new ArrayCollection;
     * @return \Comments\Entity\Comment
     */
    public function __construct() {
        $this->children = new ArrayCollection;
        $this->replies = new ArrayCollection;
        return $this;
    }
    /**
     * return title if set
     * @return string
     */
    public function getTitle(){
        return $this->title;
    }
    /**
     * collection or proxy
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getReplies()
    {
        return $this->replies;
    }
    /**
     * collection or proxy
     * @param Doctrine\Common\Collections\ArrayCollection $children
     * @return \Comments\Entity\Comment
     */
    public function setReplies($children)
    {
        $this->replies = $replies;
        return $this;
    }
    /**
     * for non-replies
     * @param string $title
     * @return \Comments\Entity\Comment
     */
    public function setTitle($title){
        $this->title = $title;
        return $this;
    }
    /**
     * get parent entity
     * @return \Comments\Entity\Comment
     */
    public function getParent(){
        return $this->parent;
    }
    /**
     * get id
     * @return int
     */
    public function getId(){
       return $this->id; 
    }
    /**
     * set id
     * @param int $moduleCommentId
     * @return \Comments\Entity\Comment
     */
    public function setId($moduleCommentId){
        $this->id;
        return $this;
    }
    /**
     * get module id
     * @return int
     */
    public function getModuleId (){
       return $this->moduleId;
    }
    /**
     * set module id
     * @param int $moduleId
     * @return \Comments\Entity\Comment
     */
    public function setModuleId ($moduleId){
        $this->moduleId = $moduleId;
        return $this;
    }
    /**
     * get user entity
     * @return type  \ZfcUserDoctrineORM\Entity\User
     */
    public function getUser(){
       return $this->user; 
    }
    /**
     * set a user entity 
     * @param  \ZfcUserDoctrineORM\Entity\User $user
     * @return \Comments\Entity\Comment
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
    public function getIsClosed()
    {
       return $this->isClosed;       
    }
    public function setIsClosed($isClosed)
    {
        $this->isClosed = (int)$isClosed;       
        return $this;
    }

    /**
     * get a set comment
     * @return string
     */
    public function getContent()
    {
       return $this->content;
    }
    /**
     * set comment
     * @param string $comment
     * @return \Comments\Entity\Comment
     */
    public function setContent($comment)
    {
        $this->content = $content;
        return $this;
    }
    /**
     * using objects for datetime as is a doctrine entity
     * @return \Datetime
     */
    public function getCreatedAt()
    {
       return $this->createdAt;
    }
    /**
     * using objects for datetime as is a doctrine entity
     * @param type $createdAt
     * @return \Comments\Entity\Comment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt;
        
        return $this;
    }
    /**
     * set an entity
     * @param \Comments\Entity\Comment $parent
     * @return \Comments\Entity\Comment
     */
    public function setParent($parent)
    {
        $this->parent=$parent;
        
        return $this;
    }
    /**
     * binary 
     * @return int
     */
    public function getHasParent()
    {
        return $this->hasParent;
    }
    /**
     * 1 or 0 
     * @param int $hasParent
     * @return \Comments\Entity\Comment
     */
    public function setHasParent($hasParent)
    {
        $this->hasParent = $hasParent;
        
        return $this;
    }    
}
