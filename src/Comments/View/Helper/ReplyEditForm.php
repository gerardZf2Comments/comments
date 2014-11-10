<?php

namespace Comments\View\Helper;


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
class ReplyEditForm extends AbstractHelper implements ServiceLocatorAwareInterface
{
     /**
     * $var string template used for view
     */
    protected $viewTemplate;

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
    public function __invoke($reply)
    { 
        //
        $data=array(
            'parent-id' => $reply->getParent()->getId(),
            'comment' => $reply->getComment(),
        );
        $form = new Form();
        $form->setData($data);
        $vMData = array('replyForm' => $form );
        $vM = new ViewModel();
        $template = 'comments/comment/reply-form-edit.phtml';
        $vM->setTemplate($template);
        return $this->getView()->render($vM);
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