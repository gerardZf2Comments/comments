<?php

namespace Comments\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

/**
 * controller handles the requests to add and render comments
 * @todo validate input, throw and catch exceptions, test
 * @todo fix all exceptions 
 * @todo delete action

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
        
        $form = $this->getForm($this->commentParams());
        if ( !$form->isValid()) {
              
           return $this->commentsRender()->commentForm($form);
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
   
    protected function getForm($data) 
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
    protected function getEditForm($data) 
    {
        $ass = array();
        $ass['id'] = $data[1];
        $ass['module-id'] = $data[2];
        $ass['comment'] = $data[3];
        $ass['title'] = $data[4];
        $form = new \Comments\Form\Comment\Edit();
        $form->setData($ass);
        return $form;
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
        //@todo - change
        if (!$canEdit) {
            //@todo write getEditForm
            $form = $this->getEditForm($this->commentParams());
            if ( !$form->isValid()) {
                return $this->commentsRender()->commentForm($form);
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
                //@todo - should this exception be caught??
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
        //@todo remove
        $commentId = 1;
        $canClose = $this->commentsValidate()->closeIsValid($commentId);
        if (!$canClose) {
            
            return $this->commentsRender()->closeFailure();
        }
        $service = $this->getServiceLocator()->get('comments_service_comment');
        
        $success = $service->close($commentId);
        if ($success) {
            
            return $this->commentsRender()->closeSuccess();
        }
        
        throw new \Comments\Controller\Exception\DomainException("Comment doesn't seem to have been closed");  
    }

}
