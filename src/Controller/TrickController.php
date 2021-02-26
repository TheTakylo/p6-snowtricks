<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\TrickCategory;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
     * @Route("/tricks/new", name="trick_new")
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(Request $request, SluggerInterface $slugger, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->get('image')->getData();

            if ($file) {
                $fileName = $fileUploader->upload($file);
                $trick->getImage()->setFilename($fileName);
            }

            $trick->setSlug(strtolower($slugger->slug($trick->getName())));
            $em->persist($trick);
            $em->flush();
        }

        return $this->render('tricks/form.html.twig', [
            'form' => $form->createView()
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