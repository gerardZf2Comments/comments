<?php

namespace Comments\View\Helper\Form;


use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Comments\Form\CommentReply as Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * Description of Comments
 *@todo refactor methods
 * @author gerard
 */
class ReplyEdit extends AbstractHelper implements ServiceLocatorAwareInterface
{
     /**
     * $var string template used for view
     */
    protected $viewTemplate = 'comments/comment/form/edit/reply.phtml';

    /**
     * @var ServiceLocator
     */
    protected $serviceLocator;

    public function __construct($viewTemplate = null)
    {
        if (is_string($viewTemplate)){
            $this->setViewTemplate($viewTemplate);
        }
    }

    /**
     * 
     * @param int $moduleId
     * @param int $limit 
     * @param string $order
     * @param string $sort
     */
    public function __invoke($reply)
    { 
        $vMData = array('replyForm' => $this->prepareForm($reply));
        $vM = new ViewModel($vMData);
        
        $vM->setTemplate($this->viewTemplate);
        return $this->getView()->render($vM);
    }

    protected function prepareForm($reply)
    {
        $formData=array(
            'parent-id' => $reply->getParent()->getId(),
            'comment' => $reply->getComment(),
            'id'=> $reply->getId(),
        );
        $form = new Form();
        $form->setData($formData);
        
        return $form;
    }
    public function setViewTemplate($vt)
    {
        $this->viewTemplate = $vt;
        return $this;
    }
    public function getViewTemplate()
    {
        return $this->viewTemplate;
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