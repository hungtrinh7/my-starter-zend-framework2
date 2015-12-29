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
use Zend\InputFilter\InputFilterInterface;

/**
 * Class Article
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Blog\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @return string
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255, nullable=false)
     * @return string
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="user_id")
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime")
     * @return \DateTime
     */
    private $dateCreated;

    private $inputFilter;

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
     * Set author
     *
     * @param \User\Entity\User $author
     * @return Article
     */
    public function setAuthor(\User\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \User\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
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