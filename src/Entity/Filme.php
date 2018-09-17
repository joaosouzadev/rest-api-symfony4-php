<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FilmeRepository")
 */
class Filme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $titulo;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     * @Assert\Range(min=1888, max=2020)
     */
    private $ano;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     * @Assert\Range(min=1, max= 300)
     */
    private $duracao;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    private $descricao;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Papel", mappedBy="filme")
    **/
    private $papeis;

    public function __construct()
    {
        $this->papeis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getAno(): ?int
    {
        return $this->ano;
    }

    public function setAno(int $ano): self
    {
        $this->ano = $ano;

        return $this;
    }

    public function getDuracao(): ?int
    {
        return $this->duracao;
    }

    public function setDuracao(int $duracao): self
    {
        $this->duracao = $duracao;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * @return Collection|Papel[]
     */
    public function getPapeis(): Collection
    {
        return $this->papeis;
    }

    public function addPapeis(Papel $papeis): self
    {
        if (!$this->papeis->contains($papeis)) {
            $this->papeis[] = $papeis;
            $papeis->setFilme($this);
        }

        return $this;
    }

    public function removePapeis(Papel $papeis): self
    {
        if ($this->papeis->contains($papeis)) {
            $this->papeis->removeElement($papeis);
            // set the owning side to null (unless already changed)
            if ($papeis->getFilme() === $this) {
                $papeis->setFilme(null);
            }
        }

        return $this;
    }
}
