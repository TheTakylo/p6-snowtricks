<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\TrickGroup;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TrickController extends AbstractController
{

    /**
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
}