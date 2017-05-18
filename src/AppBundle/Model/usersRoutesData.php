<?php
/**
 * Created by PhpStorm.
 * User: btt_9
 * Date: 18/05/2017
 * Time: 18:27
 */

namespace AppBundle\Model;


use AppBundle\Entity\Routes;
use AppBundle\Entity\Users;

class usersRoutesData
{
    function __construct(Routes $route, $users)
    {
        $this->route = $route;
        $this->users = $users;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getUsers()
    {
        return $this->users;
    }
}