<?php

namespace App\Domain\User\Dto;

use Bigyohann\DtoBundle\Attributes\ConvertProperty;
use Bigyohann\DtoBundle\Dto\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateProfileDto extends Dto
{
    #[Assert\Type(type: 'string')]
    #[Assert\Email]
    #[ConvertProperty]
    private $email;

    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 2, max: 20)]
    #[ConvertProperty]
    private $firstname;

    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 2, max: 20)]
    #[ConvertProperty]
    private $lastname;

    /**
     * @return null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return null
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param null $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return null
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param null $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }


}