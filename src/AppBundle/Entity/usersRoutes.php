<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Users;
use AppBundle\Entity\Routes;

/**
 * usersRoutes
 *
 * @ORM\Table(name="users_routes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\usersRoutesRepository")
 */
class usersRoutes
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
    * One Product has One Shipping.
    * @ORM\ManyToOne(targetEntity="Users", cascade={"remove"})
    * @ORM\JoinColumn(name="isUser", referencedColumnName="id")
    */
    private $idUser;

    /**
     * One Product has One Shipping.
     * @ORM\ManyToOne(targetEntity="Routes", cascade={"remove"})
     * @ORM\JoinColumn(name="isRoute", referencedColumnName="id")
     */
    private $idRoute;

    /**
     * @return mixed
     */
    public function getIdRoute()
    {
        return $this->idRoute;
    }

    /**
     * @param mixed $idRoute
     */
    public function setIdRoute($idRoute)
    {
        $this->idRoute = $idRoute;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

