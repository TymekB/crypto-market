<?php

namespace App\Entity;

use App\Dto\UserDto;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private ?string $id = null;

    private ?string $email = null;

    private array $roles = [];

    private ?string $password = null;

    private bool $enabled = false;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function enable(): self
    {
        $this->enabled = true;

        return $this;
    }

    public function disable(): self
    {
        $this->enabled = false;

        return $this;
    }

    public static function fromDto(UserDto $userDto): self
    {
        $user = new self();
        $user->setEmail($userDto->getEmail());
        $user->setPassword($userDto->getPassword());

        return $user;
    }

    public function toDto(): UserDto
    {
        $userDto = new UserDto();
        $userDto->setId($this->getId());
        $userDto->setEmail($this->getEmail());
        $userDto->setPassword($this->getPassword());

        return $userDto;
    }
}