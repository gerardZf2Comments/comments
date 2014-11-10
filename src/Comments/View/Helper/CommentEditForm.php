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
class CommentEditForm extends AbstractHelper implements ServiceLocatorAwareInterface
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
    public function __invoke($comment)
    { 
        //
        $data=array(
            'module-id' => $comment->getModuleId(),
            'comment' => $comment->getComment(),
            'title' => $comment->title(),
        );
        $form = new Form();
        $form->setData($data);
        $vMData = array('commentForm' => $form );
        $vM = new ViewModel();
        $template = 'comments/comment/comment-form-edit.phtml';
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