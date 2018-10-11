<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ThumbnailsRepository")
 * @ORM\Entity
 * @ORM\Table(name="thumbnails")
 */
class Thumbnails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $imagesId;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dirname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $basename;


    public function getImagesId(): ?int
    {
        return $this->imagesId;
    }

    public function setImagesId(int $imagesId): self
    {
        $this->imagesId = $imagesId;

        return $this;
    }













    public function getDirname(): ?string
    {
        return $this->dirname;
    }

    public function setDirname(string $dirname): self
    {
        $this->dirname = $dirname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBasename()
    {
        return $this->basename;
    }

    /**
     * @param mixed $basename
     */
    public function setBasename($basename): void
    {
        $this->basename = $basename;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}
