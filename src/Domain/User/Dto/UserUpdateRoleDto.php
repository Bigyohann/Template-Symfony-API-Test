<?php

namespace App\Domain\User\Dto;

use App\Http\Utils\Dto\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateRoleDto extends Dto
{
    #[Assert\Choice(choices: ["ROLE_ADMIN", "ROLE_USER"], multiple: true)]
    public array $roles = [];
}