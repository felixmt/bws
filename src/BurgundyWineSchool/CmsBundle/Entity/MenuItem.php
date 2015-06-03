<?php

namespace BurgundyWineSchool\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * MenuItem
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BurgundyWineSchool\CmsBundle\Entity\MenuItemRepository")
 * @UniqueEntity(fields="route", message="Un chemin d'accès identique existe déjà.")
 */
class MenuItem
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255, unique=true)
     */
    private $route;

    /**
    * @ORM\ManyToOne(targetEntity="BurgundyWineSchool\CmsBundle\Entity\Page", cascade={"persist"}, inversedBy="menuItem")
    * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
    */
    private $page;

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
     * Set name
     *
     * @param string $name
     * @return MenuItem
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return MenuItem
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }
    
    /**
     * Set page
     *
     * @param Page $page
     * @return Page
     */
    public function setPage(Page $page = null)
    {
        $this->page = $page;
    }


    /**
     * Get Page
     *
     * @return string 
     */
    public function getPage()
    {
        return $this->page;
    }
}
