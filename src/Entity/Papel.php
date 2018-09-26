<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use App\Annotation as App;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PapelRepository")
 * @Serializer\ExclusionPolicy("ALL")
 * @Hateoas\Relation(
 *      "person",
 *      href=@Hateoas\Route("get_pessoa", parameters={"pessoa" = "expr(object.getPessoa().getId())"})
 * )
 */
class Papel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"Default", "Deserialize"})
     * @Serializer\Expose()
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Pessoa")
    * @App\DeserializeEntity(type="App\Entity\Pessoa", idField="id", idGetter="getId", setter="setPessoa")
    * @Assert\NotBlank()
    * @Serializer\Groups({"Deserialize"})
    * @Serializer\Expose()
    **/
    private $pessoa;

    /**
    * @ORM\Column(type="string")
    * @Assert\NotBlank()
    * @Assert\Length(min=3, max=100)
    * @Serializer\Groups({"Default", "Deserialize"})
    * @Serializer\Expose()
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
