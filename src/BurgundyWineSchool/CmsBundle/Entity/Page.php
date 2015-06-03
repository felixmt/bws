<?php

namespace BurgundyWineSchool\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BurgundyWineSchool\CmsBundle\Entity\PageRepository")
 */
class Page
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
    * @ORM\OneToMany(targetEntity="BurgundyWineSchool\CmsBundle\Entity\MenuItem", cascade={"persist"}, mappedBy="page")
    */
    private $menuItem;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isHomepage", type="boolean", nullable=true)
     */
    private $isHomepage;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
    
     /**
     * Set MenuItem
     *
     * @param MenuItem $menuItem
     * @return MenuItem
     */
    public function setMenuItem(MenuItem $menuItem = null)
    {
        $this->menuItem = $menuItem;
    }


    /**
     * Get MenuItem
     *
     * @return string 
     */
    public function getMenuItem()
    {
        return $this->menuItem;
    }
    
    /**
     * Set isHomepage
     *
     * @param boolean $isHomepage
     * @return Page
     */
    public function setIsHomepage($isHomepage)
    {
        $this->isHomepage = $isHomepage;
        
        return $this;
    }


    /**
     * Get isHomepage
     *
     * @return boolean 
     */
    public function getIsHomepage()
    {
        return $this->isHomepage;
    }
}
