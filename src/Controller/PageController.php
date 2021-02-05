<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    public function index(TrickRepository $trickRepository): Response
    {
        $tricks = $trickRepository->findForHomePage();

        return $this->render('pages/index.html.twig', [
            'tricks' => $tricks
        ]);
    }
}