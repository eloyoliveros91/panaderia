<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
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
    #[Assert\Positive(message: 'El precio debe ser mayor que cero')]
    private ?float $precio = null;

    #[ORM\Column(nullable: true)]
    private ?bool $disponible = null;

    #[ORM\OneToMany(mappedBy: 'producto', targetEntity: PedidoProducto::class, orphanRemoval: true)]
    private Collection $pedidoProductos;

    public function __construct()
    {
        $this->pedidoProductos = new ArrayCollection();
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

    public function isDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(?bool $disponible): static
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * @return Collection<int, PedidoProducto>
     */
    public function getPedidoProductos(): Collection
    {
        return $this->pedidoProductos;
    }

    public function addPedidoProducto(PedidoProducto $pedidoProducto): static
    {
        if (!$this->pedidoProductos->contains($pedidoProducto)) {
            $this->pedidoProductos->add($pedidoProducto);
            $pedidoProducto->setProducto($this);
        }

        return $this;
    }

    public function removePedidoProducto(PedidoProducto $pedidoProducto): static
    {
        if ($this->pedidoProductos->removeElement($pedidoProducto)) {
            // set the owning side to null (unless already changed)
            if ($pedidoProducto->getProducto() === $this) {
                $pedidoProducto->setProducto(null);
            }
        }

        return $this;
    }
}
