<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserResetPasswordToken;
use App\Entity\UserValidationToken;
use App\Form\UserEditPasswordType;
use App\Form\UserEditProfileType;
use App\Form\UserResetPasswordType;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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

            $this->addFlash('success', 'Votre profil a bien été mis à jour.');
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre mot de passe a bien été mis à jour.');
        }

        return $this->render('user/edit.html.twig', [
            'formProfile'  => $formProfile->createView(),
            'formPassword' => $formPassword->createView()
        ]);
    }

    /**
     * @Route("/password/reset", name="user_reset_password")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $em
     * @param UserService $userService
     * @return Response
     */
    public function resetPassword(Request $request, UserRepository $userRepository, EntityManagerInterface $em, UserService $userService): Response
    {
        $formReset = $this->createForm(UserResetPasswordType::class);

        $formReset->handleRequest($request);

        if ($formReset->isSubmitted() && $formReset->isValid()) {
            $user = $userRepository->findOneBy(['email' => $formReset->getData()['email']]);

            if ($user) {
                $userService->resetPassword($user);
            }

            $this->addFlash('success', 'Les instructions de réinitialisation du mot de passe ont été envoyées à l\'adresse email indiquée');
        }

        return $this->render('user/reset_password.html.twig', [
            'formReset' => $formReset->createView()
        ]);
    }

    /**
     * @Route("/password/new/{id}/{token}", name="user_new_password")
     * @param User $user
     * @param UserResetPasswordToken $userResetPasswordToken
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function newPassword(User $user, UserResetPasswordToken $userResetPasswordToken, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(UserEditPasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $em->remove($userResetPasswordToken);

            $em->flush();

            $this->addFlash('success', 'Votre mot de passe a bien été modifié.');

            return $this->redirectToRoute('security_login');
        }

        return $this->render('user/new_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/activate/new-request/{email}", name="user_new_activation_request")
     * @param User $user
     * @param UserService $userService
     * @return Response
     */
    public function newActivationRequest(User $user, UserService $userService): Response
    {
        $userService->activateUser($user);

        $this->addFlash('success', 'Un lien d\'activation a été envoyé à l\'adresse email indiqué');

        return $this->redirectToRoute('security_login');
    }

    /**
     * @Route("/user/activate/{id}/{token}", name="user_activate")
     * @ParamConverter("user", options={"mapping": {"id": "id"}})
     * @ParamConverter("userValidationToken", options={"mapping": {"token":"token","id":"user_id"}})
     * @param User $user
     * @param UserValidationToken $userValidationToken
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function activate(User $user, UserValidationToken $userValidationToken, EntityManagerInterface $em): Response
    {
        if ($user === $userValidationToken->getUser()) {
            $user->setValidated(true);

            $em->remove($userValidationToken);
            $em->flush();

            $this->addFlash('success', 'Votre compte a bien été activé. Vous pouvez désormais vous connetcer');
        }

        return $this->redirectToRoute('security_login');
    }
}
