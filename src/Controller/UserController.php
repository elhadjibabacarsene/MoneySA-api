<?php

namespace App\Controller;

use App\services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class UserController extends AbstractController
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route(
     *     name="post",
     *     path="/api/users",
     *     methods={"POST"},
     *     defaults={
     *          "_controller"="\App\UserController::addUser",
     *          "_api_resource_class"=User::class,
     *          "_api_collection_operation_name"="post"
     *     }
     * )
     */
    public function addUser(Request $request)
    {
        return $this->userService->createUser($request);
    }
}
