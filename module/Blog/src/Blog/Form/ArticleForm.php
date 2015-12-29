<?php
/**
 * Created by PhpStorm.
 * User: HTR14290
 * Date: 22/12/2015
 * Time: 10:46
 */

namespace Blog\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Form\Form;

class ArticleForm extends Form implements ObjectManagerAwareInterface
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('article');
        $this->setObjectManager($objectManager);

        $this->add(array(
            'type' => 'hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'title',
            'options' => array(
                'label' => 'Blog title',
                'placeholder' => 'Title'
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'content',
            'options' => array(
                'label' => 'Content'
            )
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'author',
            'options' => array(
                'label'             => 'Select',
                'object_manager'    => $this->getObjectManager(),
                'target_class'      => 'User\Entity\User',
                'property'          => 'username',
                'empty_option'   => '--- please choose ---',
            )
        ));
    }

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }
}