<?php

namespace App\Controller;

use App\Form\UserRegistrationType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function register(Request $request, EntityManagerInterface $entityManager ,UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UserRegistrationType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $user->getPassword()
            ));
            $entityManager->persist($user);
            $entityManager->flush();


            $this->addFlash('success', 'Votre compte a bien ete crée !');

            return $this -> redirectToRoute("app_login");
        }
        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('target_path');
        }
        // cela retourne une erreur si le login est incorrect
        $error = $authenticationUtils->getLastAuthenticationError();
        // propose le dernier unserName entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->getUser()) {
            $this->addFlash('success', 'Connecté');
            return $this->redirectToRoute('home');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        $this->addFlash('success', 'Deconnecté');
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    // * @Route("/verify/email", name="app_verify_email")
    // * @param Request $request
    // * @return Response
    // */
    //public function verifyUserEmail(Request $request): Response
    //{
    //   $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    // validate email confirmation link, sets User::isVerified=true and persists
    //   try {
    //       $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
    //   } catch (VerifyEmailExceptionInterface $exception) {
    //       $this->addFlash('verify_email_error', $exception->getReason());

    //       return $this->redirectToRoute('app_register');
    //   }
    //  $this->addFlash('success', 'Votre adresse email à été vérifié. Merci de votre confiance !');
    //  return $this->redirectToRoute('home');
    //}

}
