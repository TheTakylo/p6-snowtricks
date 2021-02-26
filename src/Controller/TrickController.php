<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\TrickGroup;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TrickController extends AbstractController
{

    /**
     * @param TrickGroup $trickGroup
     * @param Trick $trick
     * @return Response
     */
    public function show(TrickGroup $trickGroup, Trick $trick): Response
    {
        return new Response('ok');
    }
}