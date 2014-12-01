<?php

namespace Comments\Controller\Plugin;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
//use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcUser\Authentication\Adapter\AdapterChain as AuthAdapter;

use Zend\View\Model\ViewModel;
#use Comments\Form\Comment as CommentForm;
#use Comments\Form\CommentReply as ReplyForm;

class Render extends AbstractPlugin 
implements ServiceManagerAwareInterface,
           ServiceLocatorAwareInterface
{
    protected $serviceLocator;
    protected $serviceManger;
    
    /**
     * render view model with form printing messages
     * @param Zend\Form\Form $form
     * @param bool $terminal
     * @return Zend\View\Model\ViewModel
     */
    public function AddReplyValidationFailed($form, $terminal=true)
    {
        $viewParams = array('replacementForm' => $form);
        $view = $this->getServiceLocator()->getServiceLocator()->get('comments_view_model_comment_reply_form');
        $view->setVariables($viewParams);
        $view->setTerminal($terminal);
        
        return $view;
    }
    /**
     * render form with messages in view model
     * @param Zend\Form\Form $form
     * @param boll $terminal
     * @return Zend\View\Model\ViewModel
     */
    public function AddValidationFailed($form, $terminal=true)
    {
        $viewParams = array('replacementForm' => $form);
        $view = $this->getServiceLocator()->getServiceLocator()->get('comments_view_model_comment_form');
        $view->setVariables($viewParams);
        $view->setTerminal($terminal);
        
        return $view;
    }
    public function CloseSuccess()
    {
        $vM = new ViewModel;
        $vM->setTemplate('comments/comment/close-success.phtml');
        $vM->setTerminal(true);
        return $vM;
    }
    public function CloseFailure()
    {
        $vM = new ViewModel;
        $vM->setTemplate('comments/comment/close-failure.phtml');
        $vM->setTerminal(true);
        return $vm;
    }

    public function RemoveSuccess()
    {
        $vM = new ViewModel;
        $vM->setTemplate('comments/comment/remove-success.phtml');
        $vM->setTerminal(true);
        return $vM;
    }
    public function RemoveFailure()
    {
        $vM = new ViewModel;
        $vM->setTemplate('comments/comment/remove-failure.phtml');
        $vM->setTerminal(true);
        return $vM;
    }

    /**
     * render either comment or reply sucedss view
     * @param entity $result
     * @param boolean $terminal
     * @return Zend\View\Model\ViewModel
     */
    public function EditSuccess($result, $terminal=true)
    {
        if ($result->getHasParent()) {
            return $this->Reply($result, $terminal);            
        } else {
            return $this->Comment($result, $terminal);
            
        }
    }
    public function EditFailure()
    {
        $vM = new ViewModel;
        $vM->setTemplate('comments/comment/edit-failure.phtml');
        $vM->setTerminal(true);
        return $vM;
    }
    /**
     * get('comments_view_model_comment')
     * @param entity $result
     * @param boolean $terminal
     * @return Zend\View\Model\ViewModel
     */
    public function Comment($result, $terminal=true)
    {
        $viewParams = array('comment' => $result);
        $view = $this->getServiceLocator()->getServiceLocator()->get('comments_view_model_comment');
        $view->setVariables($viewParams);
        $view->setTerminal($terminal);
        
        return $view;
    }
   /**
     * get('comments_view_model_reply')
     * @param entity $result
     * @param boolean $terminal
     * @return Zend\View\Model\ViewModel
     */
    public function Reply($result, $terminal=true)
    {        
        $viewParams = array('comment' => $result);
        $view = $this->getServiceLocator()->getServiceLocator()->get('comments_view_model_reply');
        $view->setVariables($viewParams);
        $view->setTerminal($terminal);
        
        return $view;
    }
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