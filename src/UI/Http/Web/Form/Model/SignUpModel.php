<?php

declare(strict_types=1);

namespace UI\Http\Web\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SignUpModel
{
    #[Assert\NotBlank]
    #[Assert\Email]
    protected string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 255)]
    protected string $password;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
