<?php

namespace App\Domain\User\Dto;

use App\Domain\Main\Dto\Attributes\ConvertPropertyDto;
use App\Domain\Main\Dto\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegisterDto extends Dto
{
    #[Assert\Email]
    #[Assert\NotBlank]
    #[ConvertPropertyDto]
    private ?string $email;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
    #[ConvertPropertyDto(shouldConvertAutomatically: false)]
    private ?string $password;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
    #[ConvertPropertyDto]
    private ?string $firstName;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
    #[ConvertPropertyDto]
    public ?string $lastName;

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