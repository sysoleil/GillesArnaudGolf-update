<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use App\Form\UserType;
use App\Repository\CourseRepository;
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
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // cela retourne une erreur si le login est incorrect
        $error = $authenticationUtils->getLastAuthenticationError();
        // propose le dernier unserName entré par l'utilisateur
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
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return RedirectResponse
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
     * @param UserRepository $userRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param MailerInterface $mailer
     * @param $id
     * @return RedirectResponse|Response
     */
    // je crée ma route pour ma page
    public function userUpdate(UserRepository $userRepository,
                               Request $request,
                               EntityManagerInterface $entityManager,
                               MailerInterface $mailer,
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
     * @Route("/admin_user", name="admin_user")
     * @param UserRepository $userRepository
     * @return Response
     */

    public function adminUser(UserRepository $userRepository)
    {
        $user = $userRepository->findAll(); ['name' => 'ASC'];
        return $this->render('user/adminUser.html.twig',[
            'user' => $user
        ]);
    }

    /**
     * @Route("/user_show/{id}", name="user_show")
     * @param UserRepository $userRepository
     * @param CourseRepository $courseRepository
     * @param $id
     * @return Response
     */

    public function userShow(UserRepository $userRepository,CourseRepository $courseRepository , $id)
    {
        $user = $userRepository->find($id);
        return $this->render('user/userShow.html.twig',[
            'user' => $user
        ]);
    }
}
