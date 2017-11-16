<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;

/**
 *
 */
class SpotifyController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var array
     */
    private $options;

    private $em;

    /**
     * SpotifyController constructor.
     */
    public function __construct(ContainerInterface $container, EntityManager $em)
    {
        $this->em = $em;
        $this->container = $container;
        $this->session = new Session(
            $this->getParameter('spotify_client'),
            $this->getParameter('spotify_secret'),
            $this->getParameter('spotify_redirect_uri')
        );
        $this->options = [
            'scope' => [
                'playlist-read-private',
                'user-read-private',
            ],
        ];
    }

    /**
     * @Route("connect/spotify/check", name="connect_spotify_check")
     */
    public function connectCheckAction(Request $request)
    {
        $this->session->requestAccessToken($request->query->get('code'));
        $accessToken = $this->session->getAccessToken();
        $refreshToken = $this->session->getRefreshToken();


        $user = $this->getUser();

        if($user->getSpotifyAccessToken() == $accessToken && $user->getSpotifyRefreshToken() == $refreshToken) {
            $api = new SpotifyWebAPI();
            $api->setAccessToken($accessToken);
//           $accessToken = $this->session->refreshAccessToken($refreshToken);
//            $api->setAccessToken($accessToken);
//
//            $this->em->persist($user);
//            $this->em->flush();

            $playlists = $api->getUserPlaylists($api->me()->id);
            dump($user);

            return $this->render('AppBundle:User:index.html.twig', [
                'user' => $this->getUser(),
                'playlists' => $playlists
            ]);
        }

        $user->setSpotifyAccessToken($accessToken);
        $user->setSpotifyRefreshToken($refreshToken);

        $this->em->persist($user);
        $this->em->flush();


        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $playlists = $api->getUserPlaylists($api->me()->id);

        return $this->render('AppBundle:User:index.html.twig', [
            'user' => $this->getUser(),
            'playlists' => $playlists
        ]);
    }

    /**
     * @Route("connect/spotify", name="connect_spotify")
     */
    public function authorizeAction()
    {
        header('Location: ' . $this->session->getAuthorizeUrl());
        die();
    }
}
