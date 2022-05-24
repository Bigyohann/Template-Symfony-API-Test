<?php

namespace App\Http\User;

use App\Domain\User\UserService;
use App\Exception\Api\ValidationException;
use App\Http\AppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AppController
{

    /**
     * @param UserService $userService
     */
    public function __construct(private UserService $userService)
    {
    }

    /**
     * @throws ValidationException
     */
    #[Route('/profile', name: 'user_profile_show', methods: ['GET'])]
    public function getUserProfile(): JsonResponse
    {
        $this->denyAccessUnlessGranted('edit', $this->getUser());

        $user = $this->userService->getUserById($this->getUser()->getId());
        return $this->jsonResponse($user, 200, 'retrieved', ['user:read']);
    }

    /**
     * @throws ValidationException
     */
    #[Route('/profile', name: 'user_profile_edit', methods: ['PUT'])]
    public function updateUserProfile(Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('edit', $this->getUser());

        $user = $this->userService->updateUserById($this->getUser()->getId(), $request->getContent());
        return $this->jsonResponse($user, 200, 'updated', ['user:read']);
    }

    /**
     * @return JsonResponse
     */
    #[Route('/', name: 'admin_user_index', methods: ['GET'])]
    public function getAllUsers(): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->jsonResponse($this->userService->getAllUsers(), 200, 'retrieved', ['user:read', 'admin:read']);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'admin_user_get', methods: ['GET'])]
    public function getUserById(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->jsonResponse($this->userService->getUserById($id), 200, 'retrieved', ['user:read', 'admin:read']);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'admin_user_delete', methods: ['DELETE'])]
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
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    #[Route('/{id}', name: 'admin_user_update', methods: ['PUT'])]
    public function updateUserById(int $id, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = $this->userService->updateUserById($id, $request->getContent());
        return $this->jsonResponse($user, 200, 'updated', ['user:read']);
    }

    #[Route('/{id}/role', name: 'admin_user_role_update', methods: ['PUT'])]
    public function updateUserRoleById(int $id, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = $this->userService->updateUserRoleById($id, $request->getContent());
        return $this->jsonResponse($user, 200, 'updated', ['user:read']);
    }

}
