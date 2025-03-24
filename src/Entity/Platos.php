<?php

namespace App\Entity;

use App\Repository\PlatosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatosRepository::class)]
class Platos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?float $precio = null;

    #[ORM\Column(length: 255)]
    private ?string $imagen = null;

    #[ORM\Column(length: 255)]
    private ?string $ingredientes = null;

    #[ORM\Column(length: 255)]
    private ?string $alergenos = null;

    #[ORM\Column]
    private ?bool $disponible = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creadoen = null;

    #[ORM\ManyToOne(inversedBy: 'platos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorias $categoria = null;

    /**
     * @var Collection<int, Detallespedidos>
     */
    #[ORM\OneToMany(targetEntity: Detallespedidos::class, mappedBy: 'platos')]
    private Collection $detallespedidos;

    public function __construct()
    {
        $this->detallespedidos = new ArrayCollection();
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getIngredientes(): ?string
    {
        return $this->ingredientes;
    }

    public function setIngredientes(string $ingredientes): static
    {
        $this->ingredientes = $ingredientes;

        return $this;
    }

    public function getAlergenos(): ?string
    {
        return $this->alergenos;
    }

    public function setAlergenos(string $alergenos): static
    {
        $this->alergenos = $alergenos;

        return $this;
    }

    public function isDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): static
    {
        $this->disponible = $disponible;

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

    public function getCategoria(): ?Categorias
    {
        return $this->categoria;
    }

    public function setCategoria(?Categorias $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * @return Collection<int, Detallespedidos>
     */
    public function getDetallespedidos(): Collection
    {
        return $this->detallespedidos;
    }

    public function addDetallespedido(Detallespedidos $detallespedido): static
    {
        if (!$this->detallespedidos->contains($detallespedido)) {
            $this->detallespedidos->add($detallespedido);
            $detallespedido->setPlatos($this);
        }

        return $this;
    }

    public function removeDetallespedido(Detallespedidos $detallespedido): static
    {
        if ($this->detallespedidos->removeElement($detallespedido)) {
            // set the owning side to null (unless already changed)
            if ($detallespedido->getPlatos() === $this) {
                $detallespedido->setPlatos(null);
            }
        }

        return $this;
    }
}
