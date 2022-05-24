<?php

namespace App\Domain\User;

use App\Domain\Main\Service\AppService;
use App\Domain\User\Entity\User;
use App\Domain\User\Exception\UserEmailExistException;
use App\Domain\User\Repository\UserRepository;
use App\Exception\Api\ValidationException;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService extends AppService
{
    public function __construct(
        private UserRepository              $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    /**
     * @return User[]
     */
    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /**
     * @throws Exception
     */
    public function registerUser($data): User
    {
        $user = new User();

        $this->validateAndPopulate(User::class, $data, $user, ['user:register']);

        if ($this->userRepository->findOneBy(['email' => $user->getEmail()])) {
            throw new UserEmailExistException('User with this email already exists');
        }

        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));

        $this->userRepository->save($user);
        return $user;
    }

    /**
     * @throws ValidationException
     */
    public function updateUserById(int $id, $data): User
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $userEmail = $user->getEmail();
        $this->validateAndPopulate(User::class, $data, $user, ['user:update']);

        if ($userEmail !== $user->getEmail() && $this->userRepository->findOneBy(['email' => $user->getEmail()])) {
            throw new UserEmailExistException('User with this email already exists');
        }
        $this->userRepository->save($user);

        return $user;
    }

    public function deleteUserById(int $id)
    {
        $user = $this->userRepository->find($id);
        $this->userRepository->remove($user);
    }
}
