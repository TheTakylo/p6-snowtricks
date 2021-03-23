<?php

namespace App\Controller;

use App\Repository\TrickRepository;
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
            'tricks' => $tricks,
            'total'  => $trickRepository->count([])
        ]);
    }

    /**
     * @Route("/load-tricks/{page?}", name="pages_load_tricks")
     * @param TrickRepository $trickRepository
     * @param int $page
     * @return Response
     */
    public function loadTricks(TrickRepository $trickRepository, int $page): Response
    {
        if ($page === null || $page <= 0) {
            $page = 1;
        }

        $tricks = $trickRepository->findForHomePage(15, $page);

        return $this->render('tricks/_tricks.html.twig', [
            'tricks' => $tricks
        ]);
    }
}