<?php
/**
 * Created by PhpStorm.
 * User: zerociudo
 * Date: 17.11.8
 * Time: 13.33
 */

namespace AppBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class PostFacebookLoginListener
{
    private $em;
    private $client;
    public function __construct(EntityManagerInterface $em, FacebookClient $client)
    {
        $this->em = $em;
        $this->client =$client;
    }

    public function onFacebookGetUser(InteractiveLoginEvent $event){
        $user = $event->getAuthenticationToken()->getUser();
        if(!empty($user->getPicture()))
            return;

        $fbUser = $this->client->fetchUserFromToken($user->getFbToken());

        if($user)
        {
            $user->setPicture($fbUser->getPictureUrl());
            $this->em->persist($user);
            $this->em->flush();
        }
    }
}
