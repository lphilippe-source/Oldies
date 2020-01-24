<?php

namespace App\Entity;
use App\Entity\UserData;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserDataRepository")
 * @UniqueEntity(
 * fields= {"mail"},
 * message= "l'email est deja utilisé!")
 * @UniqueEntity(
 * fields= {"name"},
 * message= "ce pseudo existe déja!"
 * )
 */
class UserData implements UserInterface
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @assert\Length(min="8", minMessage ="Votre mot de passe doit faire au moins 8 caractères")
     * @assert\EqualTo(propertyPath="passConfirm", message="Mauvaise confirmation du mot de passe")
     */
    private $password;


    public $passConfirm;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonalList", mappedBy="userid")
     */
    private $personalLists;

    public function __construct()
    {
        $this->personalLists = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getUsername(): ?string
    {
        return $this->name;
    }


    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
    public function eraseCredentials(){}

    public function getSalt(){
        return null;
    }

    public function getRoles(){
        return ['ROLE_USER'];
    }

    /**
     * @return Collection|PersonalList[]
     */
    public function getPersonalLists(): Collection
    {
        return $this->personalLists;
    }

    public function addPersonalList(PersonalList $personalList): self
    {
        if (!$this->personalLists->contains($personalList)) {
            $this->personalLists[] = $personalList;
            $personalList->setUserid($this);
        }

        return $this;
    }

    public function removePersonalList(PersonalList $personalList): self
    {
        if ($this->personalLists->contains($personalList)) {
            $this->personalLists->removeElement($personalList);
            // set the owning side to null (unless already changed)
            if ($personalList->getUserid() === $this) {
                $personalList->setUserid(null);
            }
        }

        return $this;
    }

}
