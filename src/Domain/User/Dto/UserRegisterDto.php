<?php

namespace App\Domain\User\Dto;

use App\Http\Utils\Dto\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegisterDto extends Dto
{
    #[Assert\Email]
    #[Assert\NotBlank]
    public ?string $email;

    #[Assert\NotBlank]
    public ?string $password;

    #[Assert\NotBlank]
    public ?string $firstName;

    #[Assert\NotBlank]
    public ?string $lastName;
}