<?php

namespace Testjob\TestjobBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_user")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    const ROLE_ADMINISTRATOR ='ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

    const REGISTRATION_AWAIT = false;
    const REGISTRATION_APPROVED = true;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $fio;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $login;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $password;

    /**
     * @ORM\Column(type="boolean", options={"default" : FALSE})
     */
    protected $confirmed;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $registred;

    /**
     * @ORM\Column(type="boolean", options={"default" : FALSE})
     */
    protected $banned;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthday;

    /**
     * @ORM\ManyToMany(targetEntity="Roles", inversedBy="users_group")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="author")
     */
    protected $gallery;

    private $plainPassword;

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getFio()
    {
        return $this->fio;
    }

    public function setFio($fio)
    {
        $this->fio = $fio;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getConfirmed()
    {
        return $this->confirmed;
    }

    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    }

    public function getRegistred()
    {
        return $this->registred;
    }

    public function setRegistred()
    {
        $this->registred = new \DateTime();
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getBanned()
    {
        return $this->banned;
    }

    public function setBanned($banned)
    {
        $this->banned = $banned;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        $this->password = null;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getGallery()
    {
        return $this->gallery;
    }

    public function setGallery(Image $image)
    {
        $this->gallery[] = $image;

        return $this;
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getRoles()
    {
        $roles_name = [];
        foreach ($this->roles as $item){
            $roles_name[] = $item->getRoleName();
        }

        return $roles_name;
    }

    public function addRoles(Roles $role)
    {
        $role->addUserGroup($this);
        $this->roles[] = $role;
    }

    public function getRolesList()
    {
        $roles = $this->getRoles();
        $arr = [];
        $rolesToText = $this->rolesToText();
        foreach ($roles as $item){
            $arr[] =  $rolesToText[$item];
        }

        return implode(', ', $arr);
    }

    private function rolesToText(){
        return [
            self::ROLE_ADMINISTRATOR => 'Администратор',
            self::ROLE_USER => 'Пользователь'
        ];
    }
}
