<?php


namespace App\services;


use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CommonsService
{

    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Permet de contrôler les données
     * @param object $data
     * @return JsonResponse
     */
    public function controlErrorsData(object $data)
    {
        $errors = $this->validator->validate($data);
        if($errors){
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
        }
    }
}