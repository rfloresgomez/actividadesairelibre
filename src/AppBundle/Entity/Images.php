<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Images
 *
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImagesRepository")
 */
class Images
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="idUser", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="idRoute", type="string", length=255)
     */
    private $idRoute;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Images
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set idUser
     *
     * @param string $idUser
     *
     * @return Images
     */
    public function setName($idUser)
    {
        $this->name = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return string
     */
    public function getname()
    {
        return $this->name;
    }

    /**
     * Set idRoute
     *
     * @param string $idRoute
     *
     * @return Images
     */
    public function setIdRoute($idRoute)
    {
        $this->idRoute = $idRoute;

        return $this;
    }

    /**
     * Get idRoute
     *
     * @return string
     */
    public function getIdRoute()
    {
        return $this->idRoute;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Images
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

