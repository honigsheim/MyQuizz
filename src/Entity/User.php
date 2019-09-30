<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields={"email"},
 * message="L'email est déja utilisé!"
 * )
 */
class User implements UserInterface
{



    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $roles;
 
    // public function __construct()
    // // {
    // //     $this->roles = ['ROLE_USER'];
    // }
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;
    /**
     * 
     */

    public $confirm_password;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }



    public function eraseCredentials(){

    }
    public function getSalt(){
        return null;
    }

    // /** @see \Serializable::serialize() */
    // public function serialize()
    // {
    //     return serialize(array(
    //         $this->id,
    //         $this->username,
    //          $this->email,
    //         $this->password,
            
    //     ));
    // }
 
    // /** @see \Serializable::unserialize() */
    // public function unserialize($serialized)
    // {
    //     list (
    //         $this->id,
    //         $this->username,
    //         $this->mail,
    //         $this->password,
         
    //     ) = unserialize($serialized);
    // }

    /*
    * @return array (role|string)[] the user roles
    */
    public function getRoles()
    {
        return $this->roles; 
        
    }
 
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }
}
