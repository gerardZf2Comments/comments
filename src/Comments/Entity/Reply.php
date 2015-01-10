<?php

namespace Comments\Entity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Description of ModuleComment
 *
 * @author gerard
 */
abstract class Reply
{

   
    
    protected $id;
    protected $user;
    protected $comment;
    protected $content;
    
   
    /**
     * get id
     * @return int
     */
    public function getId()
    {
       return $this->id; 
    }
    /**
     * @param int $id
     * @return \Comments\Entity\Comment
     */
    public function setId($id)
    {
        $this->id;
        return $this;
    }
   
    /**
     * get user entity
     * @return object
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
    

    /**
     * get a set comment
     * @return string
     */
    public function getComment()
    {
       return $this->comment;
    }
    /**
     * set comment
     * @param \Comments\Entity\Comment $comment
     * @return \Comments\Entity\Reply
     */
    public function setComment($comment)
    {
        $this->comment=$comment;
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
     * @return \Comments\Entity\Reply
     */
    public function setContent($content)
    {
        $this->content=$content;
        return $this;
    }
       
}
