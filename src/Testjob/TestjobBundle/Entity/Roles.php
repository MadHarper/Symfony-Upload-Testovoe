<?php

namespace Testjob\TestjobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 * @ORM\HasLifecycleCallbacks
 */
class Roles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $role_name;


    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
     */
    private $users_group;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRoleName()
    {
        return $this->role_name;
    }

    /**
     * @param mixed $role_name
     */
    public function setRoleName($role_name)
    {
        $this->role_name = $role_name;
    }

    /**
     * @return mixed
     */
    public function getUsersGroup()
    {
        return $this->users_group;
    }

    public function addUserGroup(User $user){
        $this->users_group[] = $user;
    }
}