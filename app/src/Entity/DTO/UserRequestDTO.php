<?php

declare(strict_types=1);

namespace App\Entity\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserRequestDTO
{
    /**
     * @Assert\Length(min=3)
     */
    private string $username;

    /**
     * @Assert\NotBlank()
     */
    private string $password;

    /**
     * @Assert\Email()
     */
    private string $email;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
