<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    public const TYPE_SINGLE = 0;

    public const TYPE_PARENT = 1;

    public const TYPE_VARIANT = 2;

    public const TYPE_VIRTUAL = 3;

    public const TYPE_SERVICE = 4;

    public const TYPE_BUNDLE = 5;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $SKU = null;

    #[ORM\Column(nullable: true)]
    private ?int $qty = null;

    #[ORM\Column]
    private ?int $type = null;

    /**
     * @var Collection<int, Store>
     */
    #[ORM\ManyToMany(targetEntity: Store::class, inversedBy: 'products')]
    private Collection $store;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    /**
     * @var Collection<int, ProductAttribute>
     */
    #[ORM\ManyToMany(targetEntity: ProductAttribute::class)]
    private Collection $attributes;

    public function __construct()
    {
        $this->store = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSKU(): ?string
    {
        return $this->SKU;
    }

    public function setSKU(string $SKU): static
    {
        $this->SKU = $SKU;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(?int $qty): static
    {
        $this->qty = $qty;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Store>
     */
    public function getStore(): Collection
    {
        return $this->store;
    }

    public function addStore(Store $store): static
    {
        if (!$this->store->contains($store)) {
            $this->store->add($store);
        }

        return $this;
    }

    public function removeStore(Store $store): static
    {
        $this->store->removeElement($store);

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, ProductAttribute>
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(ProductAttribute $attribute): static
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes->add($attribute);
        }

        return $this;
    }

    public function removeAttribute(ProductAttribute $attribute): static
    {
        $this->attributes->removeElement($attribute);

        return $this;
    }
}
