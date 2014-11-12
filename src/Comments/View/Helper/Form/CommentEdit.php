<?php

namespace Comments\View\Helper\Form;

use Comments\Form\Comment as Form;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * Description of Comments
 *@todo refactor methods
 * @author gerard
 */
class CommentEdit extends AbstractHelper implements ServiceLocatorAwareInterface
{
     /**
     * $var string template used for view
     */
    protected $viewTemplate;

    /**
     * @var ServiceLocator
     */
    protected $serviceLocator;

    protected $template = 'comments/comment/form/edit/comment.phtml';
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
            'id'=>$comment->getId(),
            'module-id' => $comment->getModuleId(),
            'comment' => $comment->getComment(),
            'title' => $comment->getTitle(),
        );
        $form = new Form();
        $form->setData($data);
        $vMData = array('commentForm' => $form );
        $vM = new ViewModel($vMData);
        $vM->setTemplate($this->template);
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