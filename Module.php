<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *another change
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Comments;

Class Module
{
    /**
     * return include __DIR__ . '/config/module.config.php';
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
        public function getAutoloaderConfig() {
        return array(
            
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }
     /**
     * description
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
           'factories' => array(
            'comments_service_comment' => function($sm) {
                    $service = new Service\Comment();
                    $service->setServiceLocator($sm);

                    return $service;
            },
            'comments_entity_comment' => function ($sm) {
                    $entity = new \Comments\Entity\Comment;
                    return $entity;
            },
            'comments_mapper_comment' => function ($sm) {
                    //todo - sort out some mod options
                    $options = new \Comments\Options\CommentOptions();
                    $options->setCommentEntityClassName('Comments\Entity\Comment');
                    $options->setUserEntityClassName('User\Entity\User');
                    return new \Comments\Mapper\Comment(
                            $sm->get('doctrine.entitymanager.orm_default'), $options
                    );
            },
                // todo - complete refactor
                'comments_service_comment' => function($sm) {
                    $service = new Service\Comment();
                    $service->setServiceLocator($sm);

                    return $service;
                },
                                // todo - complete refactor
                'comments_form_comment_form' => function($sm) {
                    $form = new \Comments\Form\Comment();

                    return $form;
                },
                 'comments_form_comment_reply_form' => function($sm) {
                    $form = new \Comments\Form\CommentReply();

                    return $form;
                },
                // todo - complete refactor
                'comments_view_model_reply' => function($sm) {
                    $viewModel = new \Comments\View\Model\Comment\Reply();
                    $options = new \Comments\Options\CommentOptions();
                    // $template =  $options->getViewAddReplySuccessTemplateName();
                    $template = 'comments/comment/child-comment';
                    $viewModel->setTemplate($template);

                    return $viewModel;
                },
                    // todo - complete refactor
                'comments_view_model_comment' => function($sm) {
                    $replyFormView = $sm->get('comments_view_model_comment_reply_form');
                    $vars = array('replyForm' => $replyFormView);
                    $viewModel = new \Comments\View\Model\Comment\Comment($vars);
                    
                    //$options = new \Comments\Options\CommentOptions();
                    // $template =  $options->getViewAddSuccessTemplateName();
                    $template = 'comments/comment/comment';
                    $viewModel->setTemplate($template);
                    
                 //   $viewModel->addChild($replyFormView, 'replyForm');

                    return $viewModel;
                },
                // todo - complete refactor
                'comments_view_model_comment_form' => function($sm) {
                    $viewModel = new \Zend\View\Model\ViewModel;
                    // $options = new \ZfModule\Options\ModuleOptions();
                    // $template =  $options->getViewAddSuccessTemplateName();
                    $template = 'comments/comment/form/comment';
                    $viewModel->setTemplate($template);
                    $viewModel->setVariable('commentForm', $sm->get('comments_form_comment_form'));
                    
                    return $viewModel;
                },
                // todo - complete refactor
                'comments_view_model_comment_reply_form' => function($sm) {
                    $viewModel = new \Zend\View\Model\ViewModel;
                    // $options = new \ZfModule\Options\ModuleOptions();
                    // $template =  $options->getViewAddSuccessTemplateName();
                    $template = 'comments/comment/form/reply';
                    $viewModel->setTemplate($template);
                    $viewModel->setVariable('replyForm', $sm->get('comments_form_comment_reply_form'));
                    return $viewModel;
                },
        ),
                        );
    }
    
     public function getViewHelperConfig() 
     {
        return array(
            'factories' => array(
                'Comments' => function ($sm) {
                    $commentForm = $sm->getServiceLocator()->get('comments_view_model_comment_form');
                    $replyForm = $sm->getServiceLocator()->get('comments_view_model_comment_reply_form');
                    
                    $service = $sm->getServiceLocator()->get('comments_service_comment');
                    $helper = new \Comments\View\Helper\Comments($commentForm, $replyForm, $service);
                    
                    return $helper;
                },
                'CommentEditForm' => function($sm){
                    $helper = new \Comments\View\Helper\Form\CommentEdit;
                    return $helper;
                },
                'CurrentUserIsCommentOwner' => function($sm){
                    $helper = new \Comments\View\Helper\CurrentUserIsCommentOwner;
                    return $helper;
                },
                'ReplyEditForm' => function($sm){
                    $helper = new \Comments\View\Helper\Form\ReplyEdit;
                    return $helper;
                },
                'LoginLink' => function($sm){
                    $helper = new \Comments\View\Helper\LoginLink;
                    return $helper;
                },
                 'CurrentUserIsModuleOwner' => function($sm){
                    $helper = new \Comments\View\Helper\CurrentUserIsModuleOwner;
                    return $helper;
                 }
             )
         );
     }
}

