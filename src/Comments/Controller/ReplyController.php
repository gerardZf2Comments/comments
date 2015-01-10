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
class ReplyController extends AbstractActionController
{   
   /**
    * add reply 
    * @return mixed view or redirect
    * @throws Exception\DomainException
    * @todo remove hardcoded userId
    */
    public function addAction()
    {    
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            //return $this->redirect()->toRoute('zfcuser/login');
        }
        list($user, $replyId, $parentId, $comment) = $this->replyParams();
        //@todo form move to helper 
        $form = $this->getForm($this->replyParams());
        $formIsValid = $form->isValid();
       
        if (!$formIsValid) {
            
           return $this->commentsRender()->replyForm($form);
        } 
        
        $service = $this->getServiceLocator()->get('comments_service_comment');
        $success = $service->addReply($user, $comment, $parentId);
        if ($success) {
               
            return $this->commentsRender()->reply($success, true);       
        } 
       
        $message = 'Reply not added';
           
        throw new \Exception($message);      
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
        
        list($user, $replyId, $parentId, $comment) = $this->replyParams();
        
        $canEdit = $this->commentsValidate()->editIsValid($replyId);
        //@todo validate form data.
        if (!$canEdit) {
            //@todo write getEditForm
            $form = $this->getEditForm($this->replyParams());
            if ( !$form->isValid()) {
                return $this->commentsRender()->replyForm($form);
            }
            $service = $this->getServiceLocator()->get('comments_service_comment');
        
            $success = $service->edit($commentId, $comment);
            if ($success) {
            
                return $this->commentsRender()->editSuccess($success, true);
            }
            throw new \Comments\Controller\Exception\DomainException("Comment doesn't seem to have been edited");
        }
        return $this->commentsRender()->editFailure();       
    }
    
    protected function getEditForm($data) 
    {
        $ass = array();
        $ass['id'] = $data[1];
        $ass['parent-id'] = $data[2];
        $ass['comment'] = $data[3];
        $form = new \Comments\Form\Reply\Edit;
        $form->setData($ass);
        return $form;
    }
    protected function getForm($data) 
    {
        $ass = array();
        $ass['id'] = $data[1];
        $ass['parent-id'] = $data[2];
        $ass['comment'] = $data[3];
        $form = new \Comments\Form\Reply;
        $form->setData($ass);
        return $form;
    }
    
    /**
     * array($userId, $parentCommentId, $comment);
     * @return array
     */
    protected function replyParams()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        $parentId = $this->params()->fromPost('parent-id');
        $id = $this->params()->fromPost('id');
        $comment = $this->params()->fromPost('comment');  
      
        return array($user, $id, $parentId, $comment);
    }
}
