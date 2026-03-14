<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?array $mode = [
        'store' => [
            'view' => false,
            'create' => false,
            'edit' => false,
            'delete' => false,
        ],
        'category' => [
            'view' => false,
            'create' => false,
            'edit' => false,
            'delete' => false,
        ],
        'product' => [
            'view' => false,
            'create' => false,
            'edit' => false,
            'delete' => false,
        ],
        'location' => [
            'view' => false,
            'create' => false,
            'edit' => false,
            'delete' => false,
        ],
        'role' => 'user',
    ];

    // User roles are user or admin.  Admin will ignore any other permission.

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

    public function getMode(): ?array
    {
        return $this->mode;
    }

    public function setMode(?array $mode): static
    {
        $this->mode = $mode;

        return $this;
    }
}
