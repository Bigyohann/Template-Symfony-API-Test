<?php

namespace App\Domain\User\Utils;

enum RolesEnum: string
{
    case ADMIN = "ROLE_ADMIN";
    case USER = "ROLE_USER";
}
