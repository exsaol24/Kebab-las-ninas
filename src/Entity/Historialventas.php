<?php

namespace App\Entity;

use App\Repository\HistorialventasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistorialventasRepository::class)]
class Historialventas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaventa = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\ManyToOne(inversedBy: 'historialventas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pedidos $pedido = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaventa(): ?\DateTimeInterface
    {
        return $this->fechaventa;
    }

    public function setFechaventa(\DateTimeInterface $fechaventa): static
    {
        $this->fechaventa = $fechaventa;

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

    public function getPedido(): ?Pedidos
    {
        return $this->pedido;
    }

    public function setPedido(?Pedidos $pedido): static
    {
        $this->pedido = $pedido;

        return $this;
    }
}
