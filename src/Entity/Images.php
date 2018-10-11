<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImagesRepository")
 */
class Images
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dirname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $basename;

    public function getId()
    {
        return $this->id;
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

    public function getBasename(): ?string
    {
        return $this->basename;
    }

    public function setBasename(string $basename): self
    {
        $this->basename = $basename;

        return $this;
    }
}
