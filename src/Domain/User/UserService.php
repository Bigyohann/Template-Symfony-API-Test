<?php

namespace App\Domain\User;

use App\Domain\Main\Service\AppService;
use App\Domain\User\Dto\UserRegisterDto;
use App\Domain\User\Dto\UserUpdateProfileDto;
use App\Domain\User\Dto\UserUpdateRoleDto;
use App\Domain\User\Entity\User;
use App\Domain\User\Exception\UserEmailExistException;
use App\Domain\User\Repository\UserRepository;
use Exception;
use ReflectionException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService extends AppService
{
    public function __construct(
        private readonly UserRepository              $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    /**
     * @return User[]
     */
    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @throws Exception
     */
    public function registerUser(UserRegisterDto $userRegisterDto): User
    {
        $user = new User();

        if ($this->userRepository->findOneBy(['email' => $userRegisterDto->getEmail()])) {
            throw new UserEmailExistException('User with this email already exists');
        }

        $userRegisterDto->transformToObject($user);

        $user->setPassword($this->passwordHasher->hashPassword($user, $userRegisterDto->getPassword()));

        $this->userRepository->save($user);
        return $user;
    }

    /**
     * @throws ReflectionException
     */
    public function updateUserById(int $id, UserUpdateProfileDto $userUpdateProfileDto): User
    {
        $user = $this->getUserById($id);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }


        if ($userUpdateProfileDto->getEmail()) {
            if ($userUpdateProfileDto->getEmail() !== $user->getEmail() &&
                $this->userRepository->findOneBy(['email' => $userUpdateProfileDto->getEmail()])) {
                throw new UserEmailExistException('User with this email already exists');
            }
        }

        $userUpdateProfileDto->transformToObject($user);

        $this->userRepository->save($user);

        return $user;
    }

    public function getUserById(int $id): ?User
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }
        return $user;
    }

    public function deleteUserById(int $id)
    {
        $user = $this->getUserById($id);
        $this->userRepository->remove($user);
    }

    /**
     * @throws ReflectionException
     */
    public function updateUserRoleById(int $id, UserUpdateRoleDto $userUpdateRoleDto): User
    {
        $user = $this->getUserById($id);

        $userUpdateRoleDto->transformToObject($user);

        $this->userRepository->save($user);

        return $user;
    }
}
