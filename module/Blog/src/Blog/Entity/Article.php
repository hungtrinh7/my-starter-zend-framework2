<?php
/**
 * Created by PhpStorm.
 * User: HTR14290
 * Date: 21/12/2015
 * Time: 15:53
 */

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class Article
 * @ORM\Entity
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Blog\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     * @return string
     */
    protected $title;

    /**
     * @ORM\Column(name="content", type="string", length=255, nullable=true)
     * @return string
     */
    protected $content;

    /**
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     * @return string
     */
    protected $author;

    /**
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     * @return \DateTime
     */
    protected $dateCreated;

    protected $inputFilter;

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Article
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return Article
     */
    public function getContent()
    {
        return $this->content;
    }


    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return Article
     */
    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->title = $author;
    }

    /**
     * @return Article
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }


    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->author = (isset($data['author'])) ? $data['author'] : null;
        $this->content  = (isset($data['content']))  ? $data['content']  : null;
        $this->title  = (isset($data['title']))  ? $data['title']  : null;
        //$this->dateCreated  = (isset($data['dateCreated']))  ? $data['dateCreated']  : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'id',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'author',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'content',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}