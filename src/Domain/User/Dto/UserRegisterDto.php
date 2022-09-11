<?php

namespace App\Domain\User\Dto;

use Bigyohann\DtoBundle\Attributes\ConvertProperty;
use Bigyohann\DtoBundle\Dto\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegisterDto extends Dto
{
    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
    #[ConvertProperty]
    public ?string $lastName;
    #[Assert\Email]
    #[Assert\NotBlank]
    #[ConvertProperty]
    private ?string $email;
    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
    #[ConvertProperty(shouldConvertAutomatically: false)]
    private ?string $password;
    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
    #[ConvertProperty]
    private ?string $firstName;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

}