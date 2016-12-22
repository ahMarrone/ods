<?php

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class ScopesService {

    private $entityManager;
    private $tokenStorage;

    private static $scopes = array('N'=>0,'P'=>1,'D'=>2);

    public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    // Retorna scopes de usuario.
    // Retorna array con claves 'N' (nacional),'P' (provincial),'D' (departamental) y con valores booleanos en cada una
    // de acuerdo a si tienen permiso a ese nivel o no
    public function getUserScope(){
        $user = $this->tokenStorage->getToken()->getUser();
        $ambito = 'N';//echo var_dump($user->getAmbito());
        $user_scope = array('N'=>false,'P'=>false,'D'=>false);
        switch ($ambito){
            case 'N': $user_scope['N'] = true;
            case 'P': $user_scope['P'] = true;
            case 'D': $user_scope['D'] = true;
                      break;
        }
        return $user_scope;

    }

    // Retorna lista de scopes habilitados para una meta, basándose en el scope del usuario
    // 	logueado
    public function getMetasScopes() {
        return $this->getUserScope();
        //return array('N'=>true,'P'=>false,'M'=>false);
    }


    public function getIndicadorScope(){
        return $this->getUserScope();
    }
}