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
     * description
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
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
                    $options = new \ZfModule\Options\ModuleOptions();
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
                // todo - complete refactor
                'comments_view_model_reply' => function($sm) {
                    $viewModel = new \Comments\View\Model\Comment\Reply();
                    $options = new \Comments\Options\ModuleOptions();
                    // $template =  $options->getViewAddReplySuccessTemplateName();
                    $template = 'comments/comment/child-comment';
                    $viewModel->setTemplate($template);

                    return $viewModel;
                },
                    // todo - complete refactor
                'comments_view_model_comment' => function($sm) {
                    $viewModel = new \Comments\View\Model\Comment\Comment();
                    $options = new \Comments\Options\ModuleOptions();
                    // $template =  $options->getViewAddSuccessTemplateName();
                    $template = 'comments/comment/comment';
                    $viewModel->setTemplate($template);
                    $replyFormView = $sm->get('comments_view_model_comment_reply_form');
                    $viewModel->addChild($replyFormView, 'replyForm');

                    return $viewModel;
                },
                // todo - complete refactor
                'comments_view_model_comment_form' => function($sm) {
                    $viewModel = new \Zend\View\Model\ViewModel;
                    // $options = new \ZfModule\Options\ModuleOptions();
                    // $template =  $options->getViewAddSuccessTemplateName();
                    $template = 'comments/comment/comment-form';
                    $viewModel->setTemplate($template);
                    $viewModel->setVariable('commentForm', $sm->get('comments_form_comment_form'));
                    
                    return $viewModel;
                },
                // todo - complete refactor
                'zfmodule_view_model_comment_reply_form' => function($sm) {
                    $viewModel = new \Zend\View\Model\ViewModel;
                    // $options = new \ZfModule\Options\ModuleOptions();
                    // $template =  $options->getViewAddSuccessTemplateName();
                    $template = 'comments/comment/reply-form';
                    $viewModel->setTemplate($template);
                    $viewModel->setVariable('replyForm', $sm->get('comments_form_comment_reply_form'));
                    return $viewModel;
                },
        );
    }
    
     public function getViewHelperConfig() 
     {
        return array(
            'factories' => array(
                'zfmoduleComments' => function ($sm) {
                    $helper = new \Comments\View\Helper\Comments;
                    $service = $sm->getServiceLocator()->get('comment_service_comment');
                    $helper->setCommentService($service);
                    return $helper;
                },
             )
         );
     }
}

