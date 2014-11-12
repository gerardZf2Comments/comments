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
    public function add($userId, $moduleId, $comment, $title){
        $userId = (int) $userId;
        $moduleId = (int) $moduleId;
        $comment = (string) $comment;
        $title = (string)$title;
        // WTF
        $user = $this->getUserById($userId);
         /** @var \Comments\Entity\Comment */
        $commentEntity = $this->getCommentEntity();
       // $parent = $this->getCommentEntity();
        $userId = $user->getId();
     
        $userComments =$user->getUserComments();
        
        foreach ($userComments as $userComment) {
           
        }
        $commentEntity->setUser($user);
        // END WTF
        $user->getUserComments()->add($commentEntity);
        $commentEntity->setModuleId($moduleId);
        $commentEntity->setComment($comment);
        $commentEntity->setTitle($title);
    //    $commentEntity->setParent($parent);
        $commentEntity->setHasParent(0);
        return $this->getCommentMapper()->insert($commentEntity);
    }
    public function addReply($userId, $comment, $parentCommentId)
    {
        $userId = (int) $userId;
        $parentCommentId = (int) $parentCommentId;
        $comment = (string) $comment;
        
        
        $commentMapper = $this->getCommentMapper();
        $em = $commentMapper->getEntityManager();
        $parentComment = $em->find( $commentMapper->getCommentEntityClass(), 
                                  $parentCommentId);
        $moduleId = $parentComment->getModuleId();
        $user = $em->find('User\Entity\User', $userId);
        /** @var \Comments\Entity\Comment */
        $commentEntity = $this->getCommentEntity();
        $userId = $user->getId();
        $commentEntity->setUser($user);
        $commentEntity->setModuleId($moduleId);
        $commentEntity->setParent($parentComment);
        $commentEntity->setComment($comment);
        $commentEntity->setHasParent(1);
        
        return $this->getCommentMapper()->insert($commentEntity);
    }

    /**
     * 
     * @param int $userId
     * @param int $moduleId
     * @param int $commentId
     * @param string $comment
     * @return type
     * @throws Exc
     */
    public function edit(  $commentId, $comment, $title, $user )
    {
       
        $moduleId = (int) $moduleId;
        $commentId = (int) $commentId;
        $comment = (string) $comment;
       
        /** @var \Comments\Entity\Comment */
        $commentEntity = $this->getCommentMapper()->findBy('id', $commentId);
        if (!$commentEntity) {
            throw new Exception;
        }
        if(!is_object($user)|| !$this->hasPermission($commentEntity, $user)){
            throwException('not the correct logged in user!!!!');
        }
        $commentEntity->setTitle($title);
        $commentEntity->setComment($comment);
        
        return $this->getCommentMapper()->update($commentEntity);
    }
    /**
     * 
     * @param int $userId
     * @param int $moduleId
     * @param int $comment
     * @return type
     * @throws Exc
     */
    public function delete($userId, $moduleId, $commentId)
    {
        $userId = (int) $userId;
        $moduleId = (int) $moduleId;
        $commentId = (int) $commentId;
        
        $commentEntity = $this->getCommentMapper()->find($commentId);
        if(!$commentEntity){ 
            throw new Exception;
        }
       
        return $this->getCommentMapper()->delete($commentEntity);
    }
    public function close($commentId)
    {
        $commentId = (int) $commentId;
        
        $commentEntity = $this->getCommentMapper()->find($commentId);
        if(!$commentEntity){ 
            throw new Exception;
        }
       
          $commentEntity->setIsClosed(1);
          $this->getCommentMapper()->persist($commentEntity);
    }
   /**
    * 
    * @param int $moduleId
    * @return array array of comment objects
    */
    public function commentsByModuleId($moduleId, $limit = 15, $sort = null, $order= null)
    {
        return $this->getCommentMapper()->findParentsWhere('moduleId',$moduleId, $limit,  $sort, $order);
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
    public function getCommentMapper()
    {
        return $this->getServiceLocator()->get('comments_mapper_comment');
        
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
        $commentMapper = $this->getCommentMapper();
        $em = $commentMapper->getEntityManager();
        
        return $em->find( $commentMapper->getUserEntityClass(), 
                                  $id);
    }

    protected function hasPermission($commentEntity, $user)
    {
        $commentUser = $commentEntity->getUser();
        $commentUserId = $commentUser->getId();
        if($commentUserId === $user->getId()){
            return true;
        }
        return false;
    }
 }


