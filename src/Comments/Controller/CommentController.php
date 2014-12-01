<?php

namespace Comments\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

/**
 * controller handles the requests to add and render comments
 * @todo validate input, throw and catch exceptions, test
 * @todo make this clearly fully ajax
 * @todo fix all exceptions 
 * @todo remove hard coded user id
 * @todo create render helper
 * @author gerard
 */
class CommentController extends AbstractActionController
{
   
    
    /**
     * add comment, user must be logged in
     * @return view model
     * @throws \Comments\Controller\Exception\DomainException
     * @todo remove hardcoded user id
     */
    public function addAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }
        list($user, $moduleId, $id, $comment, $title) = $this->commentParams();           
             
        $service = $this->getServiceLocator()->get('comments_service_comment');
        //@todo instanciate this in helper and return it
        $form = new \Comments\Form\Comment();
        $formIsValid = $this->commentsValidate()->validateCommentForm($form, $moduleId, $comment, $title);
          
        if (!$formIsValid) {
              
           return $this->commentsRender()->addValidationFailed($form);
        } 
            
        $success = $service->add($user, $moduleId, $comment, $title);         
       
        // it seems the add function either returns a collection or something else
        if ($success) {
            $success = $success;
            
            return $this->commentsRender()->comment($success, true); 
        }
        
        $message = 'Comment not added';
        
        throw new Exception\DomainException($message);
        
    }
   
    protected function getEditForm($data) 
    {
        $ass = array();
        $ass['id'] = $data[1];
        $ass['module-id'] = $data[2];
        $ass['comment'] = $data[3];
        $ass['title'] = $data[4];
        $form = new \Comments\Form\Comment;
        $form->setData($ass);
        return $form;
    }
    /**
     * render view model with form printing messages
     * @param Zend\Form\Form $form
     * @param bool $terminal
     * @return Zend\View\Model\ViewModel
     */
    protected function renderAddReplyValidationFailed($form, $terminal=true)
    {
        $viewParams = array('replacementForm' => $form);
        $view = $this->getServiceLocator()->get('comments_view_model_comment_reply_form');
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
    protected function renderAddValidationFailed($form, $terminal=true)
    {
        $viewParams = array('replacementForm' => $form);
        $view = $this->getServiceLocator()->get('comments_view_model_comment_form');
        $view->setVariables($viewParams);
        $view->setTerminal($terminal);
        
        return $view;
    }

   /**
    * add reply 
    * @return mixed view or redirect
    * @throws Exception\DomainException
    * @todo remove hardcoded userId
    */
    public function addReplyAction()
    {    

        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            //return $this->redirect()->toRoute('zfcuser/login');
        }
        list($user, $parentCommentId, $comment) = $this->replyParams();
        //@todo form move to helper 
        $form = new \Comments\Form\CommentReply();
        $formIsValid = $this->commentsValidate()->validateReplyForm($form, $parentCommentId, $comment);
       
        if (!$formIsValid) {
            
           return $this->commentsRender()->replyValidationFailed($form);
        } 
                   
        $service = $this->getServiceLocator()->get('comments_service_comment');
        $success = $service->addReply($user, $comment, $parentCommentId);
        if ($success) {
               
            return $this->commentsRender()->reply($success, true);       
        } 
       
        $message = 'Reply not added';
           
        throw new Exception\DomainException($message);      
    }
    
    /**
     * array($userId, $parentCommentId, $comment);
     * @return array
     */
    protected function replyParams()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        $parentCommentId = $this->params()->fromPost('parent-id');
        $comment = $this->params()->fromPost('comment');  
      
        return array($user, $parentCommentId, $comment);
    }

    /**
     * return array($userId, $moduleId, $comment, $title);
     * @return array
     */
    protected function commentParams()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        $id = $this->params()->fromPost('id', '');
        $moduleId = $this->params()->fromPost('module-id', '');
        $comment = $this->params()->fromPost('comment', '');
        $title = $this->params()->fromPost('title', '');
        
        return array($user, $id, $moduleId, $comment, $title);
    }
    
    /**
     * edit comment, user must be logged in
     * @return Zend\View\Model\ViewModel
     * @throws \Comments\Controller\Exception\DomainException
     */
    public function editAction()
    {
        //create a login function to save from this bs
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            //return $this->redirect()->toRoute('zfcuser/login');
        }
      
        list($user, $commentId, $moduleId, $comment, $title) = $this->commentParams();
        
        $canEdit = $this->commentsValidate()->editIsValid($commentId);
        //@todo validate form data.
        if (!$canEdit) {
            //@todo write getEditForm
            $form = $this->getEditForm($this->commentParams());
            if ( !$form->isValid()) {
                return $this->commentsRender()->editFormError($form);
            }
            $service = $this->getServiceLocator()->get('comments_service_comment');
        
            $success = $service->edit($commentId, $comment, $title);
            if ($success) {
            
                return $this->commentsRender()->editSuccess($success, true);
            }
            throw new \Comments\Controller\Exception\DomainException("Comment doesn't seem to have been edited");
        }
        return $this->commentsRender()->editFailure();       
    }
    
    /**
     * remove a comment
     * @return mixed either redirect or view
     * @throws \Comments\Controller\Exception\RuntimeException
     */
    public function removeAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            
            return $this->redirect()->toRoute('zfcuser/login');
        }
       
        list($user, $commentId) = $this->commentParams();
       
        $canRemove = $this->commentsValidate()->removeIsValid($commentId);
        if ($canRemove) {
            $service = $this->getServiceLocator()->get('comments_service_comment');
            try {
                $service->delete($commentId);          
            
                return $this->commentsRender()->removeSuccess();
            } catch ( \Doctrine\ORM\ORMInvalidArgumentException $ex) {
                
                return $this->renderRemoveFailure();
            }
        }
        return $this->commentsRender()->removeFailure();
         
    }
    
    public function closeAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            
            return $this->redirect()->toRoute('zfcuser/login');
        }
       
        list($user, $commentId) = $this->commentParams();
        $commentId = 1;
        $canClose = $this->commentsValidate()->closeIsValid($commentId);
        if (!$canClose) {
            //@todo-write this function
            return $this->commentsRender()->closeFailure();
        }
        $service = $this->getServiceLocator()->get('comments_service_comment');
        
        $success = $service->close($commentId);
        if ($success) {
            
            return $this->commentsRender()->closeSuccess();
        }
        
        throw new \Comments\Controller\Exception\DomainException("Comment doesn't seem to have been closed");  
    }
    
    protected function renderCloseSuccess()
    {
        $vM = new ViewModel;
        $vM->setTemplate('comments/comment/close-success.phtml');
        $vM->setTerminal(true);
        return $vM;
    }
    protected function renderCloseFailure()
    {
        $vM = new ViewModel;
        $vM->setTemplate('comments/comment/close-failure.phtml');
        $vM->setTerminal(true);
        return $vm;
    }

    protected function renderRemoveSuccess()
    {
        $vM = new ViewModel;
        $vM->setTemplate('comments/comment/remove-success.phtml');
        $vM->setTerminal(true);
        return $vM;
    }
    protected function renderRemoveFailure()
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
    protected function renderEditSuccess($result, $terminal=true)
    {
        if ($result->getHasParent()) {
            return $this->renderReply($result, $terminal);            
        } else {
            return $this->renderComment($result, $terminal);
            
        }
    }
    protected function renderEditFailure()
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
    protected function renderComment($result, $terminal=true)
    {
        $viewParams = array('comment' => $result);
        $view = $this->getServiceLocator()->get('comments_view_model_comment');
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
    protected function renderReply($result, $terminal=true)
    {        
        $viewParams = array('comment' => $result);
        $view = $this->getServiceLocator()->get('comments_view_model_reply');
        $view->setVariables($viewParams);
        $view->setTerminal($terminal);
        
        return $view;
    }
}
