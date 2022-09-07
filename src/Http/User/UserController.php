<?php

namespace App\Http\User;

use App\Domain\User\Dto\UserRegisterDto;
use App\Domain\User\Dto\UserUpdateProfileDto;
use App\Domain\User\Dto\UserUpdateRoleDto;
use App\Domain\User\Entity\User;
use App\Domain\User\UserService;
use App\Http\AppController;
use Exception;
use ReflectionException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/user')]
class UserController extends AppController
{

    /**
     * @param UserService $userService
     */
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    #[Route('/profile', name: 'user_profile_show', methods: ['GET'])]
    public function getUserProfile(#[CurrentUser] User $user): JsonResponse
    {
        $user = $this->userService->getUserById($user->getId());
        return $this->jsonResponse($user, 200, 'retrieved');
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'user_get', methods: ['GET'])]
    public function getUserById(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }
        return $this->jsonResponse($this->userService->getUserById($id), 200, 'retrieved');
    }

    /**
     * @throws ReflectionException
     */
    #[Route('/profile', name: 'user_profile_edit', methods: ['PUT'])]
    public function updateUserProfile(UserUpdateProfileDto $userUpdateProfileDto, #[CurrentUser] User $user): JsonResponse
    {
        $user = $this->userService->updateUserById($user->getId(), $userUpdateProfileDto);
        return $this->jsonResponse($user, 200, 'created');
    }

    /**
     * @param int $id
     * @param UserUpdateProfileDto $userUpdateProfileDto
     * @return JsonResponse
     * @throws ReflectionException
     */
    #[Route('/{id}', name: 'user_update', methods: ['PUT'])]
    public function updateUserById(int $id, UserUpdateProfileDto $userUpdateProfileDto): JsonResponse
    {
        $user = $this->userService->updateUserById($id, $userUpdateProfileDto);
        return $this->jsonResponse($user, 200, 'updated');
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    #[Route('/', name: 'user_register', methods: ['POST'])]
    public function registerUser(UserRegisterDto $userRegisterDto): JsonResponse
    {
        $user = $this->userService->registerUser($userRegisterDto);
        return $this->jsonResponse($user, 200, 'updated');
    }

    /**
     * @return JsonResponse
     */
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function getAllUsers(): JsonResponse
    {
        return $this->jsonResponse($this->userService->getAllUsers(), 200, 'retrieved');
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function deleteUserById(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }
        $this->denyAccessUnlessGranted('view', $user);
        $this->userService->deleteUserById($id);
        return $this->jsonResponse([], 204, 'deleted');
    }

    /**
     * @throws ReflectionException
     */
    #[Route('/{id}/role', name: 'user_role_update', methods: ['PUT'])]
    public function updateUserRoleById(int $id, UserUpdateRoleDto $userUpdateRoleDto): JsonResponse
    {
        $user = $this->userService->updateUserRoleById($id, $userUpdateRoleDto);
        return $this->jsonResponse($user, 200, 'updated');
    }

}
