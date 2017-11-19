<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

    /**
     * @var EntityManager
     */
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
                'user-library-read',
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

        if ($user->getSpotifyAccessToken() == $accessToken && $user->getSpotifyRefreshToken() == $refreshToken) {
            $api = new SpotifyWebAPI();
            $api->setAccessToken($accessToken);
//           $accessToken = $this->session->refreshAccessToken($refreshToken);
//            $api->setAccessToken($accessToken);
//
//            $this->em->persist($user);
//            $this->em->flush();

            $playlists = $api->getUserPlaylists($api->me()->id);
            dump($user);

            return $this->render(
                'AppBundle:User:index.html.twig',
                [
                    'user' => $this->getUser(),
                    'playlists' => $playlists,
                ]
            );
        }

        $user->setSpotifyAccessToken($accessToken);
        $user->setSpotifyRefreshToken($refreshToken);

        $this->em->persist($user);
        $this->em->flush();


        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        dump($api);
        $spotify_user = $api->me();
        $limit = 50;
        $offset = 49;
        $user_songs = $api->getMySavedTracks(
            [
                'limit' => $limit,
            ]
        );
        $total = $user_songs->total;
        $songs[] = $user_songs->items;
        while ($offset < $total) {
            $songs[] = $api->getMySavedTracks(
                [
                    'limit' => $limit,
                    'offset' => $offset,
                ]
            )->items;
            $offset += 50;
        }
        dump($spotify_user);
        dump($songs);

        return $this->render(
            'AppBundle:User:index.html.twig',
            [
                'user' => $this->getUser(),
                'songs' => $songs,
            ]
        );
    }

    /**
     * @Route("connect/spotify", name="connect_spotify")
     */
    public function authorizeAction()
    {
        return new RedirectResponse($this->session->getAuthorizeUrl($this->options));
    }
}
