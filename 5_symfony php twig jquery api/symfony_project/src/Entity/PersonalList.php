<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonalListRepository")
 */
class PersonalList
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $favorites = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserData", inversedBy="personalLists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFavorites(): ?array
    {
        return $this->favorites;
    }

    public function setFavorites(array $favorites): self
    {
        $this->favorites = $favorites;

        return $this;
    }

    public function getUserid(): ?UserData
    {
        return $this->userid;
    }

    public function setUserid(?UserData $userid): self
    {
        $this->userid = $userid;

        return $this;
    }
}
