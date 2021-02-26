<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\TrickGroup;
use App\Repository\TrickRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/tricks/{group_slug}/{trick_slug}", name="trick_show")
     * @param TrickGroup $trickGroup
     * @param Trick $trick
     * @Entity("trickGroup", expr="repository.findOneBySlug(group_slug)")
     * @Entity("trick", expr="repository.findOneBySlugAndGroupSlug(trick_slug, group_slug)")
     * @return Response
     */
    public function show(TrickGroup $trickGroup, Trick $trick): Response
    {
        return $this->render('tricks/show.html.twig', [
            'trick'      => $trick,
            'trickGroup' => $trickGroup
        ]);
    }

    /**
     * @Route("/tricks/{slug?}", name="trick_list")
     * @param TrickRepository $trickRepository
     * @param TrickGroup|null $trickGroup
     * @return Response
     */
    public function list(TrickRepository $trickRepository, ?TrickGroup $trickGroup = null): Response
    {
        $tricks = $trickRepository->findList($trickGroup);

        return $this->render('tricks/list.html.twig', [
            'tricks'     => $tricks,
            'trickGroup' => $trickGroup
        ]);
    }
}