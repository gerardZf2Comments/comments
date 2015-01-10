<?php

namespace Comments\View\Helper;


use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * Description of Comments
 *@todo refactor methods
 * @author gerard
 */
class CurrentUserIsCommentOwner extends AbstractHelper implements ServiceLocatorAwareInterface
{

    /**
     * @var ServiceLocator
     */
    protected $serviceLocator;

    public function __invoke($comment)
    {   
        $user = $this->getView()->zfcUserIdentity();
        if (!$user){
            return false;
        }
        $userId = $user->getId();
        $commentUserId = $comment->getUser()->getId();
        if( $userId === $commentUserId) {
            return true;        
        }
        return false;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * {@inheritdoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }
    
}