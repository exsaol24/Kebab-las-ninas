<?php

namespace App\Entity;

use App\Repository\CategoriasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriasRepository::class)]
class Categorias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creadoen = null;

    /**
     * @var Collection<int, Platos>
     */
    #[ORM\OneToMany(targetEntity: Platos::class, mappedBy: 'categoria')]
    private Collection $platos;

    public function __construct()
    {
        $this->platos = new ArrayCollection();
        $this->creadoen = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCreadoen(): ?\DateTimeInterface
    {
        return $this->creadoen;
    }

    public function setCreadoen(\DateTimeInterface $creadoen): static
    {
        $this->creadoen = $creadoen;

        return $this;
    }

    /**
     * @return Collection<int, Platos>
     */
    public function getPlatos(): Collection
    {
        return $this->platos;
    }

    public function addPlato(Platos $plato): static
    {
        if (!$this->platos->contains($plato)) {
            $this->platos->add($plato);
            $plato->setCategoria($this);
        }

        return $this;
    }

    public function removePlato(Platos $plato): static
    {
        if ($this->platos->removeElement($plato)) {
            // set the owning side to null (unless already changed)
            if ($plato->getCategoria() === $this) {
                $plato->setCategoria(null);
            }
        }

        return $this;
    }
}
