<?php

namespace App\Domain\User\Dto;

use Bigyohann\DtoBundle\Attributes\ConvertProperty;
use Bigyohann\DtoBundle\Dto\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateRoleDto extends Dto
{
    #[Assert\Choice(choices: ["ROLE_ADMIN", "ROLE_USER"], multiple: true)]
    #[ConvertProperty]
    private array $roles = [];

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}