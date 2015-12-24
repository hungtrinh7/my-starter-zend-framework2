<?php
/**
 * Created by PhpStorm.
 * User: HTR14290
 * Date: 22/12/2015
 * Time: 10:46
 */

namespace Blog\Form;

use Zend\Form\Form;

class ArticleForm extends Form
{
    public function __construct()
    {
        parent::__construct('article');

        $this->add(array(
            'type' => 'hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'title',
            'options' => array(
                'label' => 'Blog title'
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
            'type' => 'text',
            'name' => 'author',
            'options' => array(
                'label' => 'Author'
            )
        ));
    }
}