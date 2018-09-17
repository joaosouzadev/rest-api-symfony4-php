<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PapelRepository")
 */
class Papel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Pessoa")
    **/
    private $pessoa;

    /**
    * @ORM\Column(type="string")
    **/
    private $personagem;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Filme", inversedBy="papeis")
    **/
    private $filme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonagem(): ?string
    {
        return $this->personagem;
    }

    public function setPersonagem(string $personagem): self
    {
        $this->personagem = $personagem;

        return $this;
    }

    public function getPessoa(): ?Pessoa
    {
        return $this->pessoa;
    }

    public function setPessoa(?Pessoa $pessoa): self
    {
        $this->pessoa = $pessoa;

        return $this;
    }

    public function getFilme(): ?Filme
    {
        return $this->filme;
    }

    public function setFilme(?Filme $filme): self
    {
        $this->filme = $filme;

        return $this;
    }
}
