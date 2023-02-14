<?php

declare(strict_types=1);

namespace App\Entity\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequestDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min={3})
     */
    public string $username;

    /**
     * @Assert\NotBlank()
     * @Assert\NotCompromisedPassword()
     */
    public string $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $email;

    public function __construct(Request $request)
    {
        $this->username = $request->get('username');
        $this->password = $request->get('pasword');
        $this->email = $request->get('email');
    }
}