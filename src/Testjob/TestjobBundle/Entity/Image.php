<?php

namespace Testjob\TestjobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="images")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="gallery", cascade={"persist"})
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $comment;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Неправильный тип загружаемого файла")
     * @Assert\File(
     *      maxSize="5242880",
     *      mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "image/gif",
     *      }
     * )
     */
    protected $image;

    public function getId()
    {
        return $this->id;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(User $user)
    {
        $user->setGallery($this);
        $this->author = $user;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
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