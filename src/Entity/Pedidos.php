<?php

namespace App\Entity;

use App\Repository\PedidosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidosRepository::class)]
class Pedidos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $direccionentrega = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column(length: 255)]
    private ?string $metodopago = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechapedido = null;

    /**
     * @var Collection<int, Detallespedidos>
     */
    #[ORM\OneToMany(targetEntity: Detallespedidos::class, mappedBy: 'pedido')]
    private Collection $detallespedidos;

    /**
     * @var Collection<int, Historialventas>
     */
    #[ORM\OneToMany(targetEntity: Historialventas::class, mappedBy: 'pedido')]
    private Collection $historialventas;

    #[ORM\ManyToOne(inversedBy: 'pedidos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuarios $usuarios = null;

    #[ORM\ManyToOne(inversedBy: 'pedidos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Estadospedidos $estado = null;

    public function __construct()
    {
        $this->detallespedidos = new ArrayCollection();
        $this->historialventas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDireccionentrega(): ?string
    {
        return $this->direccionentrega;
    }

    public function setDireccionentrega(string $direccionentrega): static
    {
        $this->direccionentrega = $direccionentrega;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getMetodopago(): ?string
    {
        return $this->metodopago;
    }

    public function setMetodopago(string $metodopago): static
    {
        $this->metodopago = $metodopago;

        return $this;
    }

    public function getFechapedido(): ?\DateTimeInterface
    {
        return $this->fechapedido;
    }

    public function setFechapedido(\DateTimeInterface $fechapedido): static
    {
        $this->fechapedido = $fechapedido;

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
            $detallespedido->setPedido($this);
        }

        return $this;
    }

    public function removeDetallespedido(Detallespedidos $detallespedido): static
    {
        if ($this->detallespedidos->removeElement($detallespedido)) {
            // set the owning side to null (unless already changed)
            if ($detallespedido->getPedido() === $this) {
                $detallespedido->setPedido(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Historialventas>
     */
    public function getHistorialventas(): Collection
    {
        return $this->historialventas;
    }

    public function addHistorialventa(Historialventas $historialventa): static
    {
        if (!$this->historialventas->contains($historialventa)) {
            $this->historialventas->add($historialventa);
            $historialventa->setPedido($this);
        }

        return $this;
    }

    public function removeHistorialventa(Historialventas $historialventa): static
    {
        if ($this->historialventas->removeElement($historialventa)) {
            // set the owning side to null (unless already changed)
            if ($historialventa->getPedido() === $this) {
                $historialventa->setPedido(null);
            }
        }

        return $this;
    }

    public function getUsuarios(): ?Usuarios
    {
        return $this->usuarios;
    }

    public function setUsuarios(?Usuarios $usuarios): static
    {
        $this->usuarios = $usuarios;

        return $this;
    }

    public function getEstado(): ?Estadospedidos
    {
        return $this->estado;
    }

    public function setEstado(?Estadospedidos $estado): static
    {
        $this->estado = $estado;

        return $this;
    }
}
