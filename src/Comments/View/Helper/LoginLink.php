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
class LoginLink extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public $linkClass = "comment-login-link comment-button";
    public function __invoke($view, $message = null)
    {
        
        $args = array();
        $args[] = $this->linkClass; 
        $args[] = $view->url('scn-social-auth-user/login/provider', array('provider' => 'github'));
        $args[] =(is_string($message)) ? $message : $view->translate('Login to reply');
               
        $format='<a class="%s" href="%s">%s</a>';
        
        return sprintf($format, $args[0], $args[1], $args[2]);
        
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