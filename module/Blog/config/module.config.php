<?php

namespace Blog;

return array(
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'router' => array(
        // Open configuration for all possible routes
        'routes' => array(
            // Define a new route called "article"
            'blog' => array(
                // Define the routes type to be "Zend\Mvc\Router\Http\Literal", which is basically just a string
                'type' => 'literal',
                // Configure the route itself
                'options' => array(
                    // Listen to "/blog" as uri
                    'route'    => '/blog',
                    // Define default controller and action to be called when this route is matched
                    'defaults' => array(
                        'controller' => 'Blog\Controller\List',
                        'action'     => 'index',
                    )
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'show' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/article/:id',
                            'defaults' => array(
                                'controller' => 'Blog\Controller\List',
                                'action' => 'show'
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            )
                        )
                    ),
                    'edit' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/article/edit/:id',
                            'defaults' => array(
                                'controller' => 'Blog\Controller\Write',
                                'action' => 'edit'
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            )
                        )
                    ),
                    'delete' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/article/delete/:id',
                            'defaults' => array(
                                'controller' => 'Blog\Controller\Write',
                                'action' => 'delete'
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            )
                        )
                    ),
                    'add' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route'    => '/article/add',
                            'defaults' => array(
                                'controller' => 'Blog\Controller\Write',
                                'action'     => 'add'
                            )
                        )
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Blog\Controller\List' => 'Blog\Controller\ListController',
            'Blog\Controller\Write' => 'Blog\Controller\WriteController',
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            //'Blog\Service\ArticleService' => 'Blog\Service\Factory\ArticleServiceFactory'
        )
    ),
);