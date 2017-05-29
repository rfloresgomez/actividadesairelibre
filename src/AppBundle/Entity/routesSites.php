<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Sites;
use AppBundle\Entity\Routes;

/**
 * routesSites
 *
 * @ORM\Table(name="routes_sites")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\routesSitesRepository")
 */
class routesSites
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
     * @ORM\ManyToOne(targetEntity="Sites", cascade={"remove"})
     * @ORM\JoinColumn(name="idSite", referencedColumnName="id")
     */
    private $idSite;

    /**
     * @return mixed
     */
    public function getIdSite()
    {
        return $this->idSite;
    }

    /**
     * @param mixed $idSite
     */
    public function setIdSite($idSite)
    {
        $this->idSite = $idSite;
    }

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
     * One Product has One Shipping.
     * @ORM\ManyToOne(targetEntity="Routes", cascade={"remove"})
     * @ORM\JoinColumn(name="idRoute", referencedColumnName="id")
     */
    private $idRoute;


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

