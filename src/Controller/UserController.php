<?php

namespace App\Controller;

use App\Form\UserEditPasswordType;
use App\Form\UserEditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/profil/edit", name="user_edit")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();

        $formProfile = $this->createForm(UserEditProfileType::class, $user);
        $formPassword = $this->createForm(UserEditPasswordType::class, $user);

        $formProfile->handleRequest($request);
        $formPassword->handleRequest($request);

        if ($formProfile->isSubmitted() && $formProfile->isValid()) {
            $em->persist($user);
            $em->flush();

            // TODO: alert success
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();

            // TODO: alert success
        }

        return $this->render('user/edit.html.twig', [
            'formProfile'  => $formProfile->createView(),
            'formPassword' => $formPassword->createView()
        ]);
    }
}