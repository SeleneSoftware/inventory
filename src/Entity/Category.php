<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?bool $base = null;

    #[ORM\OneToOne(targetEntity: self::class, inversedBy: 'parent', cascade: ['persist', 'remove'])]
    private ?self $subcategory = null;

    #[ORM\OneToOne(targetEntity: self::class, mappedBy: 'subcategory', cascade: ['persist', 'remove'])]
    private ?self $parent = null;

    /**
     * @var Collection<int, Store>
     */
    #[ORM\OneToMany(targetEntity: Store::class, mappedBy: 'category')]
    private Collection $store;

    public function __construct()
    {
        $this->store = new ArrayCollection();
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

    public function isBase(): ?bool
    {
        return $this->base;
    }

    public function setBase(?bool $base): static
    {
        $this->base = $base;

        return $this;
    }

    public function getSubcategory(): ?self
    {
        return $this->subcategory;
    }

    public function setSubcategory(?self $subcategory): static
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        // unset the owning side of the relation if necessary
        if ($parent === null && $this->parent !== null) {
            $this->parent->setSubcategory(null);
        }

        // set the owning side of the relation if necessary
        if ($parent !== null && $parent->getSubcategory() !== $this) {
            $parent->setSubcategory($this);
        }

        $this->parent = $parent;

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
            $store->setCategory($this);
        }

        return $this;
    }

    public function removeStore(Store $store): static
    {
        if ($this->store->removeElement($store)) {
            // set the owning side to null (unless already changed)
            if ($store->getCategory() === $this) {
                $store->setCategory(null);
            }
        }

        return $this;
    }
}
