<?php

namespace Comments\Controller\Plugin;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
//use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcUser\Authentication\Adapter\AdapterChain as AuthAdapter;
#use Comments\Form\Comment as CommentForm;
#use Comments\Form\CommentReply as ReplyForm;

class Validate extends AbstractPlugin 
implements ServiceManagerAwareInterface,
           ServiceLocatorAwareInterface
{
     /**
     * set data and call is valid
     * @param Zend\Form\Form $form
     * @param int $parentCommentId
     * @param string $comment
     * @return bool
     */
    public function validateReplyForm($form,  $commentId, $comment) 
    {
        $form->setData(array(
            'id' => $commentId,
            'comment'=> $comment,               
        ));
        
        return $form->isValid();
    }

    
     /**
     * set data & valiadte comment form
     * @param Zend\Form\Form $form
     * @param int $moduleId
     * @param string $comment
     * @param string $title
     * @return bool
     */
    public function validateCommentForm($form, $moduleId, $comment, $title)
    {
        $form->setData(array(
            'module-id' => $moduleId,
            'comment'=> $comment,
            'title' => $title,               
        ));
        
        return $form->isValid();
    }
    
    public function removeIsValid($commentId)
    {
        return $this->isValid($commentId); 
    }
    
    public function closeIsValid($commentId)
    {
        return $this->isValid($commentId);
    }
    
    /*
     * rules are - only comment creator can edit (for now)
     */
    public function editIsValid($commentId)
    {
        $user = $this->getCurrentUser();
        if (!$user){
            return false;
        }
        $userId = $user->getId();
        $comment = $this->getCommentById($commentId);
        if (!$comment) {
            return false;
        }
        $commentUserId = $comment->getUser()->getId();
        if( $userId === $commentUserId)
        {
            return true;        
        }
        return false;
    }
    
    protected function getCommentById($commentId)
    {
        $cM = $this->getServiceLocator()->getServiceLocator()->get('comments_mapper_comment');
        $comment = $cM->findby('id', $commentId);
        if (!$comment) {
            return false;
        }
        return $comment[0];
    }
    
    protected function getCurrentUser()
    {
        return $this->getController()->zfcUserAuthentication()->getIdentity();
    }
    
    /*
     * rules are - if the comment and user exist proceed
     *             if current user is owner of module related to comment proceed  
     *             if current user is creator of comment proceed
     */       
    public function isValid($commentId)
    {
        $isUsersComment = false;
        $isUsersModule = false;
        
        $comment = $this->getCommentById($commentId);
        if (!$comment) {
            return false;
        }
        
        $user = $this->getCurrentUser();
        if (!$user) {
            return false;
        }
        if ( $user->getId() === $comment->getUser()->getId()) {
            $isUsersComment = true;
            return $isUsersComment;
        }
        $username = $user->getUsername();
        $moduleId = $comment->getModuleId();
        
        if ($this->moduleIsOwnedBy($moduleId, $username)){
            $isUsersModule = true;
            return $isUsersModule;
        } 
        return false;
     }
     
     protected function moduleIsOwnedBy($moduleId, $username)
     {
        $mM = $this->getServiceLocator()->getServiceLocator()->get('zfmodule_mapper_module');
        if ($mM->moduleIsOwnedBy($moduleId, $username)){            
            return true;
        } 
        return false;
     }

     protected $serviceLocator;
    protected $serviceManger;
    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceLocator ()
    {
        return $this->serviceLocator;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $locator
     * @return void
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface  $serviceManager)
    {
        $this->serviceLocator = $serviceManager;
    }
    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager->getServiceLocator();
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $locator
     * @return void
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}