<?php

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Shared\Domain\Service\UlidService;
use App\Users\Domain\Service\UserPasswordHasherInterface;
//use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;


class User implements AuthUserInterface
{
    private string $ulid;
    private string $email;
    private ?string $password = null;
    private array $roles = [];

    private bool $blocked;

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email)
    {
        $this->ulid = UlidService::generate();
        $this->email = $email;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBlocked(): bool
    {
        return $this->blocked;
    }

//    public function setEmail($email)
//    {
//        $this->email = $email;
//    }

    public function setEmailToLowercase()
    {
        $this->email = strtolower($this->email);
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function hasRole($role) {
        return in_array($role, $this->roles);
    }
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function addRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function removeRole($role) {
        $index = array_search($role, $this->roles);
        unset($this->roles[$index]);
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function setPassword(?string $password, UserPasswordHasherInterface $passwordHasher): void
    {
//        $this->password = $passwordHasher->hashPassword($this, $password);
        if (is_null($password)) {
            $this->password = null;
        } else {
        $this->password = $passwordHasher->hash($this, $password);
        }
    }
}