<?php

namespace App\Entity;

use App\Repository\DetallespedidosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetallespedidosRepository::class)]
class Detallespedidos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\Column]
    private ?float $preciounitario = null;

    #[ORM\Column(length: 255)]
    private ?string $personalizacion = null;

    #[ORM\ManyToOne(inversedBy: 'detallespedidos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pedidos $pedido = null;

    #[ORM\ManyToOne(inversedBy: 'detallespedidos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Platos $platos = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): static
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getPreciounitario(): ?float
    {
        return $this->preciounitario;
    }

    public function setPreciounitario(float $preciounitario): static
    {
        $this->preciounitario = $preciounitario;

        return $this;
    }

    public function getPersonalizacion(): ?string
    {
        return $this->personalizacion;
    }

    public function setPersonalizacion(string $personalizacion): static
    {
        $this->personalizacion = $personalizacion;

        return $this;
    }

    public function getPedido(): ?Pedidos
    {
        return $this->pedido;
    }

    public function setPedido(?Pedidos $pedido): static
    {
        $this->pedido = $pedido;

        return $this;
    }

    public function getPlatos(): ?Platos
    {
        return $this->platos;
    }

    public function setPlatos(?Platos $platos): static
    {
        $this->platos = $platos;

        return $this;
    }
}
