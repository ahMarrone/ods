<?php
// src/AppBundle/Entity/Usuarios.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


class Usuarios extends BaseUser
{

    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}

