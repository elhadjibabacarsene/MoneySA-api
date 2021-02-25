<?php

namespace App\Controller;

use App\services\CompteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Compte;

class CompteController extends AbstractController
{

    private $compteService;

    public function __construct(CompteService $compteService)
    {
        $this->compteService = $compteService;
    }

    public function addCompteTransaction(Request $request)
    {
        return $this->compteService->createCompte($request);
    }
}
