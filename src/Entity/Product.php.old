<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    // /**
    //  * @var Collection<int, Store>
    //  */
    // #[ORM\ManyToMany(targetEntity: Store::class, inversedBy: 'products')]
    // private Collection $store;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $attributes = [];

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent')]
    private ?self $variants = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'variants')]
    private Collection $parent;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    public function __construct()
    {
        $this->store = new ArrayCollection();
        $this->parent = new ArrayCollection();
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

    // /**
    //  * @return Collection<int, Store>
    //  */
    // public function getStore(): Collection
    // {
    //     return $this->store;
    // }
    //
    // public function addStore(Store $store): static
    // {
    //     if (!$this->store->contains($store)) {
    //         $this->store->add($store);
    //     }
    //
    //     return $this;
    // }
    //
    // public function removeStore(Store $store): static
    // {
    //     $this->store->removeElement($store);
    //
    //     return $this;
    // }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getVariants(): ?self
    {
        return $this->variants;
    }

    public function setVariants(?self $variants): static
    {
        $this->variants = $variants;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): static
    {
        if (!$this->parent->contains($parent)) {
            $this->parent->add($parent);
            $parent->setVariants($this);
        }

        return $this;
    }

    public function removeParent(self $parent): static
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getVariants() === $this) {
                $parent->setVariants(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
