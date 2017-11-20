<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", length=255, nullable=true)
     */
    private $facebookId;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", nullable=true)
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="fb_token", type="string")
     */
    private $fbToken;

    /**
     * @var string
     *
     * @ORM\Column(name="spotify_access_token",type="string", nullable=true)
     */
    private $spotify_access_token;

    /**
     * @var string
     *
     * @ORM\Column(name="spotify_refresh_token",type="string", nullable=true)
     */
    private $spotify_refresh_token;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string")
     */
    private $role;

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getSpotifyAccessToken()
    {
        return $this->spotify_access_token;
    }

    /**
     * @param mixed $spotify_access_token
     */
    public function setSpotifyAccessToken($spotify_access_token)
    {
        $this->spotify_access_token = $spotify_access_token;
    }

    /**
     * @return mixed
     */
    public function getSpotifyRefreshToken()
    {
        return $this->spotify_refresh_token;
    }

    /**
     * @param mixed $spotify_refresh_token
     */
    public function setSpotifyRefreshToken($spotify_refresh_token)
    {
        $this->spotify_refresh_token = $spotify_refresh_token;
    }

    /**
     * @return mixed
     */
    public function getFbToken()
    {
        return $this->fbToken;
    }

    /**
     * @param mixed $fbToken
     */
    public function setFbToken($fbToken)
    {
        $this->fbToken = $fbToken;
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

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }
    public function getRoles()
    {
        $roles[] = 'user';
        return $roles;
    }
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }
    public function getUsername()
    {
        return $this->firstname . " " . $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }
}
