<?php

namespace Comments\Controller\Plugin;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
//use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcUser\Authentication\Adapter\AdapterChain as AuthAdapter;

class ValidateParams extends AbstractPlugin 
implements ServiceManagerAwareInterface,
           ServiceLocatorAwareInterface
{
    public function removeIsValid($commentId)
    {
        return $this->isValid($commentId); 
    }
    public function closeIsValid($commentId)
    {
        return $this->isValid($commentId);
    }
    public function isValid($commentId)
    {
        $isUsersComment = false;
        $isUsersModule = false;
        $cM = $this->getServiceLocator()->get('comments_mapper_comment');
        $comment = $cM->findby('id', $commentId);
        if (!$comment) {
            return false;
        }
        $comment = $comment[0];
        $user = $this->getController()->zfcUserAuthentication()->getIdentity();
        if (!user) {
            return false;
        }
        if ( $user->getId() === $comment->getUser()->getId()) {
            $isUsersComment = true;
            return $isUsersComment;
        }
        $username = $user->getUsername();
        $moduleId = $comment->getModuleId();
        $mM = $this->getServiceLocator()->get('zfmodule_mapper_module');
        if ($mM->moduleIsOwnedBy($moduleId, $username)){
            $isUsersModule = true;
            return $isUsersModule;
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