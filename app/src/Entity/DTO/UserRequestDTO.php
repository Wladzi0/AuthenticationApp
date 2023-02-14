<?php

declare(strict_types=1);

namespace App\Entity\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequestDTO
{
    /**
     * @Assert\Length(min={3})
     */
    public string $username;

    /**
     * @Assert\NotCompromisedPassword()
     */
    public string $password;

    /**
     * @Assert\Email()
     */
    public string $email;

    public function __construct(Request $request)
    {
        $this->username = $request->get('username');
        $this->password = $request->get('password');
        $this->email = $request->get('email');
    }
}
