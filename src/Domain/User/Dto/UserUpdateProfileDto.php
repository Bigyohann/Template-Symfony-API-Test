<?php

namespace App\Domain\User\Dto;

use App\Http\Utils\Dto\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateProfileDto extends Dto
{
    #[Assert\Email]
    public ?string $email = null;

    #[Assert\Length(min: 2, max: 20)]
    public ?string $firstname = null;

    #[Assert\Length(min: 2, max: 20)]
    public ?string $lastname = null;

}