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
class CurrentUserIsModuleOwner extends AbstractHelper implements ServiceLocatorAwareInterface
{

    /**
     * @var ServiceLocator
     */
    protected $serviceLocator;

    /**
     * 
     * @param int $moduleId
     * @param int $limit 
     * @param string $order
     * @param string $sort
     */
    public function __invoke($comment)
    {   
        $user = $this->getView()->zfcUserIdentity();
        if (!$user) {
            return false;
        }
        $username = $user->getUsername();
        
        $moduleId = $comment->getModuleId();
        $mM = $this->getServiceLocator()->getServiceLocator()->get('zfmodule_mapper_module');
        if( $mM->moduleIsOwnedBy($moduleId, $username)) {
        
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