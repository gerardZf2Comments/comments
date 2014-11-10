<?php
return array(
     'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            
          
            'comments_entity_comment'  => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/xml/comment'
            ),
           
            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    
                    'Comments\Entity\Comment'  => 'comments_entity_comment',
                    
                )
            ),
            
        )
    ),
    'controllers' => array(
        'invokables' => array(
        
            'Comments\Controller\Comment' => 'Comments\Controller\CommentController',
            
        ),
        'aliases' => array(
           
            
        ),
    ),
    /**
    'console' => array(
        'router' => array(
            'routes' => array(
          'view-module' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => 'index/all',
                    'defaults' => array(
                        'controller' => 'ZfModule\Controller\SearchIndexer',
                        'action' => 'all',
                    ),
                ),
            ),
            )
        )
     ),
*/
    'router' => array(
        'routes' => array(
            /**
            'view-module' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/:vendor/:module',
                    'defaults' => array(
                        'controller' => 'ZfModule\Controller\Index',
                        'action' => 'view',
                    ),
                ),
            ),
             * 
             */
            
            // comment routes 
            'comment' => array(
                'type' => 'Segment',
                'options' => array (
                    'route' => '/comment',
                    'defaults' => array(
                        'controller' => 'Comments\Controller\Comment',
                        'action' => 'list',
                    ),
                ),
                'may_terminate' => true,
                'priority' => 1000,
                'child_routes' => array(
                    'add' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/add',
                            
                            'defaults' => array(
                                'action' => 'add',
                            ),
                        ),
                    ),
                    'add-reply' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/add-reply',
                            
                            'defaults' => array(
                                'action' => 'addReply',
                            ),
                        ),
                    ),
                    'remove' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/remove',
                            
                            'defaults' => array(
                                'action' => 'remove',
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/edit',
                            
                            'defaults' => array(
                                'action' => 'edit',
                            ),
                        ),
                    ),
                  ),
                ),
            // end comment routes 
            
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'comments' => __DIR__ . '/../view',
        ),
    ),

    'view_helpers' => array(
        'invokables' => array(
            
            ),
        
    ),
    
);
