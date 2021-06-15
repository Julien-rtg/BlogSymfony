<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $admin_login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $admin_password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdminLogin(): ?string
    {
        return $this->admin_login;
    }

    public function setAdminLogin(string $admin_login): self
    {
        $this->admin_login = $admin_login;

        return $this;
    }

    public function getAdminPassword(): ?string
    {
        return $this->admin_password;
    }

    public function setAdminPassword(string $admin_password): self
    {
        $this->admin_password = $admin_password;

        return $this;
    }
}
