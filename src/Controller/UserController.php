<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
//use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security\UserAuthenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;


class UserController extends AbstractController

{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/user_create", name="user_create")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param MailerInterface $mailer
     * @return Response
     */
    public function user_create(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            $this->addFlash('success', 'inscription confirmé');
            return $this->redirectToRoute('home');

            // generate a signed url and email it to the user

           // $this->('app_verify_email', $user,
           //     (new TemplatedEmail())
           //         ->from(new Address('sylvie.ferrer@lapiscine.pro', 'Gilles Arnaud'))
           //         ->to($user->getEmail())
           //         ->subject('Confirmation email')
           //         ->htmlTemplate('user/registrationTemplate.html.twig')
        ;

            // do anything else you need here, like send an email
        }

        return $this->render('user/userCreate.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // cela retourne une erreur si le login est incorrect
        $error = $authenticationUtils->getLastAuthenticationError();
        // // propose le dernier unserName entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->getUser()) {
            $this->addFlash('success', 'Connecté');
            return $this->redirectToRoute('home');
        }

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
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
    /**
     * @Route("/user_delete/{id}", name="user_delete")
     */

    public function userDelete(UserRepository $userRepository,
                               EntityManagerInterface $entityManager,
                               $id)
    {
        $user = $userRepository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('success', 'Le compte a bien été supprimé');
        return $this->redirectToRoute('admin_user');
    }

    /**
     * @Route("/user_update/{id}", name="user_update")
     */
    // je crée ma route pour ma page
    public function userUpdate(UserRepository $userRepository,
                               Request $request,
                               EntityManagerInterface $entityManager,
                               $id)
        // Je veux récupérer une instance de la variable 'UserRepository $userRepository'
        //J'isntancie dans la variable la class pour récupérer les valeurs requises
        //Cette méthode Request permet de récupérer les données de la méthode post
    {
        $user = $userRepository->find($id);
        //j'appelle le cours dans le repository cours avec la wildcard

        $userForm = $this->createForm(UserType::class, $user);
        // je récupère le gabarit de formulaire de l'entité User,
        //  créé  dans la console avec la commande make:form.
        // et je le stocke dans une variable $userForm

        if ($request->isMethod('POST')) {
            $userForm->handleRequest($request);

            //Je prends les données de ma requête et je les envois au formulaire
            if ($userForm->isSubmitted() && $userForm->isValid()) {
                $entityManager->persist($user);
                // la méthode persist indique de récupérer la variable User modifiée et d'insérer
                $entityManager->flush();
                // la méthode 'flush' enregistre la modification
                // puis j'éxécute l'URL et je vais raffraichir ma DBB

                return $this->redirectToRoute('home');
            }
        }
        $this->addFlash('success', 'Votre compte a bien été modifié');
        //J'ajoute un message flash pour confirmer la modif
        $form = $userForm->createView();
        //Je crée une nouvelle route pour revenir sur l'utilisateur
        return $this->render('user/userUpdate.html.twig', [
            'userForm' => $form
            // je retourne mon fichier twig, en lui envoyant
            // la vue du formulaire, générée avec la méthode createView()
        ]);
    }
    /**
     * @Route("/user_show", name="user_show")
     */

    public function userShow(UserRepository $userRepository)
    {
        $user = $userRepository->findAll();
        return $this->render('user/userShow.html.twig',[
            'user' => $user
        ]);
    }
}
