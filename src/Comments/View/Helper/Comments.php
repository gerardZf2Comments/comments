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
class Comments extends AbstractHelper implements ServiceLocatorAwareInterface
{
     /**
     * $var string template used for view
     */
    protected $viewTemplate = 'comments/comment/comments.phtml';
    
    protected $commentForm;
    protected $replyForm;

    /**
     * @var ServiceLocator
     */
    protected $serviceLocator;

    public function __construct($commentForm, $replyForm, $service) 
    {
        $this->commentForm = $commentForm;
        $this->replyForm = $replyForm;
        $this->setCommentService($service);
    }

    /**
     * 
     * @param int $moduleId
     * @param int $limit 
     * @param string $order
     * @param string $sort
     */
    public function __invoke($moduleId, $limit = 15, $order=null, $sort =null)
    {        
        $service = $this->getCommentService();
        $comments = $service->commentsByModuleId($moduleId, $limit, $sort, $order);
        $commentForm = $this->getServiceLocator()->getServiceLocator()->get('comments_view_model_comment_form');
        $replyForm = $this->getServiceLocator()->getServiceLocator()->get('comments_view_model_comment_reply_form');
         $vm = new ViewModel(array(
            'comments' => $comments,
            'moduleId' => $moduleId,
            'commentForm' => $this->commentForm,
            'replyForm' => $replyForm,
        ));
         $vm->addChild($replyForm, 'replyForm');
        $vm->setTemplate($this->viewTemplate);
        /////////////////////////////////
         
        $commentForm->setVariable('moduleId', $moduleId);
        
        return $this->getView()->render($vm);
        //////////////////////////////////////
       /*
        $this->commentForm->setVariable('moduleId', $moduleId);
        
        $vm->addChild($this->commentForm, 'commentForm');
        $vm->addChild($this->replyForm, 'replyForm');
        return $this->getView()->render($vm);
        */
    }
    public function setCommentService($cs){
        $this->commentService = $cs;
        return $this;
    }
    /**
     * 
     * @return \Comments\Service\Comment
     */
    public function getCommentService(){
        return $this->commentService;
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


