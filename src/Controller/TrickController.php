<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\TrickCategory;
use App\Repository\TrickRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/tricks/{category_slug}/{trick_slug}", name="trick_show")
     * @param TrickCategory $trickCategory
     * @param Trick $trick
     * @Entity("trickCategory", expr="repository.findOneBySlug(category_slug)")
     * @Entity("trick", expr="repository.findOneBySlugAndCategorySlug(trick_slug, category_slug)")
     * @return Response
     */
    public function show(TrickCategory $trickCategory, Trick $trick): Response
    {
        return $this->render('tricks/show.html.twig', [
            'trick'         => $trick,
            'trickCategory' => $trickCategory
        ]);
    }

    /**
     * @Route("/tricks/{slug?}", name="trick_list")
     * @param TrickRepository $trickRepository
     * @param TrickCategory|null $trickCategory
     * @return Response
     */
    public function list(TrickRepository $trickRepository, ?TrickCategory $trickCategory = null): Response
    {
        $tricks = $trickRepository->findList($trickCategory);

        return $this->render('tricks/list.html.twig', [
            'tricks'        => $tricks,
            'trickCategory' => $trickCategory
        ]);
    }
}