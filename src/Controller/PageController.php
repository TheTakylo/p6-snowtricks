<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use App\Service\VideoServiceFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{

    /**
     * @Route("/", name="pages_index")
     * @param TrickRepository $trickRepository
     * @return Response
     */
    public function index(TrickRepository $trickRepository): Response
    {
        $tricks = $trickRepository->findForHomePage();

        return $this->render('pages/index.html.twig', [
            'tricks' => $tricks
        ]);
    }
}