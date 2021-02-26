<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\TrickCategory;
use App\Entity\TrickComment;
use App\Form\TrickCommentType;
use App\Form\TrickType;
use App\Repository\TrickCommentRepository;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickController extends AbstractController
{
    /**
     * @Route("/tricks/new", name="trick_new")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setSlug(strtolower($slugger->slug($trick->getName())));
            $em->persist($trick);
            $em->flush();

            return $this->redirectToRoute('trick_show', [
                'category_slug' => $trick->getTrickCategory()->getSlug(),
                'trick_slug'    => $trick->getSlug()
            ]);
        }

        return $this->render('tricks/form.html.twig', [
            'form'  => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/tricks/edit/{id}", name="trick_edit")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @param Trick $trick
     * @param SluggerInterface $slugger
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Trick $trick, SluggerInterface $slugger, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setSlug(strtolower($slugger->slug($trick->getName())));
            $em->persist($trick);
            $em->flush();

            return $this->redirectToRoute('trick_show', [
                'category_slug' => $trick->getTrickCategory()->getSlug(),
                'trick_slug'    => $trick->getSlug()
            ]);
        }

        return $this->render('tricks/form.html.twig', [
            'form'  => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/tricks/delete/{id}", name="trick_delete")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @param Trick $trick
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Trick $trick, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-trick-' . $trick->getId(), $request->get('_csrf_token'))) {
            $em->remove($trick);
            $em->flush();

            $this->addFlash('success', 'La figure a bien été supprimé');
        }

        return $this->redirectToRoute('pages_index');
    }

    /**
     * @Route("/tricks/{category_slug}/{trick_slug}", name="trick_show")
     * @param TrickCategory $trickCategory
     * @param Trick $trick
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     * @Entity("trickCategory", expr="repository.findOneBySlug(category_slug)")
     * @Entity("trick", expr="repository.findOneBySlugAndCategorySlug(trick_slug, category_slug)")
     */
    public function show(TrickCategory $trickCategory, Trick $trick, Request $request, EntityManagerInterface $em, TrickCommentRepository $trickCommentRepository): Response
    {
        $pageSize = 10;
        $page = $request->query->getInt('page', 1);
        $totalPages = 0;
        $comments = [];

        $commentsCount = $trickCommentRepository->count(['trick' => $trick]);

        if ($commentsCount) {
            $totalPages = ceil($commentsCount / $pageSize);

            if ($page > $totalPages) {
                $page = $totalPages;
            }

            $offset = ($page - 1) * $pageSize;

            $comments = $trickCommentRepository->findBy(['trick' => $trick], ['createdAt' => 'ASC'], $pageSize, $offset);
        }

        $trickComment = new TrickComment();
        $form = $this->createForm(TrickCommentType::class, $trickComment);

        $form->handleRequest($request);

        if ($this->getUser() && $form->isSubmitted() && $form->isValid()) {
            $trickComment->setUser($this->getUser());
            $trickComment->setTrick($trick);

            $em->persist($trickComment);
            $em->flush();

            $this->addFlash('success', 'Votre commentaire a bien été ajouté');
            return $this->redirect($request->getUri());
        }

        return $this->render('tricks/show.html.twig', [
            'trick'           => $trick,
            'trickCategory'   => $trickCategory,
            'comments'        => $comments,
            'paginateTotal'   => $totalPages,
            'paginateCurrent' => $page,
            'form'            => $form->createView()
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