<?php

namespace Comments\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * manages comments coupled with a entity manager +more
 *@todo test
 * @author gerard
 */
class Comment {
 
    /**
     * 
     * @param int $userId
     * @param int $moduleId
     * @param string $comment
     * @param string title
     * @return type
     * @throws Exc
     */
    public function add($user, $moduleId, $comment, $title)
    {
        
        $moduleId = (int) $moduleId;
        $comment = (string) $comment;
        $title = (string)$title;
        
        
         /** @var \Comments\Entity\Comment */
        $commentEntity = $this->getCommentEntity();        
        $commentEntity->setUser($user);
        //@todo - is this needed for doctrine?
        $user->getUserComments()->add($commentEntity);
        $commentEntity->setModuleId($moduleId);
        $commentEntity->setComment($comment);
        $commentEntity->setTitle($title);
    
        $commentEntity->setHasParent(0);
        try{
            return $this->getCommentMapper()->insert($commentEntity);
        } catch (\Exception $ex) {
            return false; 
        }
             
   }
    public function addReply($user, $comment, $parentId)
    {
        
        $commentMapper = $this->getCommentMapper();
        $em = $commentMapper->getEntityManager();
        //@todo - write something in case object isn't found 
        $parentComment = $em->find( $commentMapper->getCommentEntityClass(), 
            $parentId
        );
        
        $moduleId = $parentComment->getModuleId();
        
        /** @var \Comments\Entity\Comment */
        $commentEntity = $this->getCommentEntity();
        
        $commentEntity->setUser($user);
        $commentEntity->setModuleId($moduleId);
        $commentEntity->setParent($parentComment);
        $commentEntity->setComment($comment);
        $commentEntity->setHasParent(1);
        
        try {
            return $this->getCommentMapper()->insert($commentEntity);
        } catch (\Exception $exc) {
            return false;
        }        
    }

    /**
     * 
     * @param int $commentId
     * @param string $comment
     * @param string $title Description
     * @return mixed
     */
    public function edit(  $commentId, $comment, $title = "")
    {
        $commentId = (int) $commentId;
        $comment = (string) $comment;
        $title = (string) $title;
       
        /** @var \Comments\Entity\Comment */
        $commentEntity = $this->getCommentById($commentId);
        if (!$commentEntity) {
            return false;
        }
        $commentEntity->setTitle($title);
        $commentEntity->setComment($comment);
        
        try {
            return $this->getCommentMapper()->update($commentEntity);    
        } catch (\Exception $ex) {
            return false;
        }
        
    }
    /**
     * 
     * @param int $commentId
     * @return mixed false || object
     */
    public function delete($commentId)
    {
        $commentId = (int) $commentId;
        
         /** @var \Comments\Entity\Comment */
        $commentEntity = $this->getCommentById(commenttId);
        if (!$commentEntity) {
            return false;
        }
    
        try {
            return $this->getCommentMapper()->delete($commentEntity);
        } catch (\Exception $exc) {
            return false;
        }
    }
    public function close($commentId)
    {
        $commentId = (int) $commentId;
        
         /** @var \Comments\Entity\Comment */
        $commentEntity = $this->getCommentById($commentId);
        if (!$commentEntity) {
            return false;
        }
       
        $commentEntity->setIsClosed(1);
          
        try {
            $this->getCommentMapper()->insert($commentEntity);
            return true;
        } catch (\Exception $exc) {
              return false;
        }          
    }
   /**
    * 
    * @param int $moduleId
    * @return array array of comment objects
    */
    public function getCommentById($commentId)
    {
        try{
            $comment = $this->getCommentMapper()->findBy('id', $commentId);
        } catch (\Exception $ex) { 
            return false;
        }
        if (!$comment) {
            return false;
        }
        return $comment[0];
    }
    /**
    * 
    * @param int $moduleId
    * @return array array of comment objects
    */
    public function commentsById($type, $moduleId, $limit = 15, $sort = null, $order= null)
    {
        try {
            return $this->getCommentMapper($type)->findParentsWhere('moduleId',$moduleId, $limit,  $sort, $order);
        } catch (\Exception $ex) {
            return false;
        }
    }
    /**
    * 
    * @return \Zend\ServiceManager\ServiceLocatorInterface
    */
    public function getServiceLocator() 
    {
        return $this->serviceLocator;
    }
    /**
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sm
     * @return $this
     */
    public function setServiceLocator(ServiceLocatorInterface $sm) 
    {
        $this->serviceLocator = $sm;
        return $this;
    }
    /**
     * 
     * @return \Comments\Mapper\Comment
     */
    public function getCommentMapper($type)
    {
        return $this->getServiceLocator()->get($this->config[$type]['mapper']);
        
    }

    /**
     * 
     * @return \Comments\Entity\Comment
     */
    public function getCommentEntity()
    {
        return $this->getServiceLocator()->get('comments_entity_comment');
    }
     /**
     * 
     * @return \ZfcUserDoctrineORM\Entity\User
     */
    public function getUserById($id)
    {
        $em = $this->getEntityManager();
        $commentMapper = $this->getCommentMapper();
        try{
            return $em->find(
                //@todo insert this info in service
                $commentMapper->getUserEntityClass(), 
                $id
            );
        } catch (\Exception $ex) {
            return false;
        }
    }
    /*
     * @todo do this in service
     */
    protected function getEntityManager()
    {
        $commentMapper = $this->getCommentMapper();
        return $commentMapper->getEntityManager();
    }
}


