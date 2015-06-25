<?php
/**
*   Appearance Entity
*
*   PHP version 5.5.12
*
*   @category  PHP
*   @package   AdminBundle
*   @author    Felix MOTOT <felix@motot.fr>
*   @copyright 2015 Félix Motot
*   @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
*   @link      http://burgundywineschool.com
*/
namespace BurgundyWineSchool\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Appearance
 *
 * @category  PHP
 * @package   Trunkadmin
 * @author    Felix MOTOT <felix@motot.fr>
 * @copyright 2015 Félix Motot
 * @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
 * @link      http://soprasteria.com  
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BurgundyWineSchool\AdminBundle\Entity\AppearanceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Appearance
{
    /**
     * Id
     *
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
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;
    
    /**
     * @Assert\File(maxSize="1024000")
     */
    public $file; // to be renamed firstground
    
    /**
     * @var string
     *
     * @ORM\Column(name="background_path", type="string", length=255, nullable=true)
     */
    private $backgroundPath;
    
    /**
     * @Assert\File(maxSize="5048000")
     */
    public $backgroundImage;
    
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // generate filename
            // $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
            $this->path = 'background-content.jpg';
        }
        if (null !== $this->backgroundImage) {
            $this->backgroundPath = 'background.jpg';
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file && null === $this->backgroundImage) {
            return;
        }

        // if error in file move exception showed up and entity wont be saved
        if ($this->file !== null) {
            $this->file->move($this->getUploadRootDir(), $this->path);

            unset($this->file);
        } 
        if ($this->backgroundImage !== null) {
            $this->backgroundImage->move($this->getUploadRootDir(), $this->backgroundPath);

            unset($this->backgroundImage);
        }
    }

    // /**
     // * @ORM\PostRemove()
     // */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }


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
     * Set path
     *
     * @param string $path
     *
     * @return Appearance
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Set backgroundPath
     *
     * @param string $backgroundPath
     *
     * @return Appearance
     */
    public function setBackgroundPath($path)
    {
        $this->backgroundPath = $path;

        return $this;
    }

    /**
     * Get backgroundPath
     *
     * @return string 
     */
    public function getBackgroundPath()
    {
        return $this->backgroundPath;
    }
}
