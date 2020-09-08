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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;


class UserController extends AbstractController

{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/user", name="admin_user")
     */

    public function adminUser(UserRepository $userRepository)
    {
        // je veux récupérer une instance de la variable 'UserRepository $userRepository...'
        //J'instancie dans la variable la class pour récupérer les valeurs requises

        // je crée ma route pour ma page d'utilisateur

        $users = $userRepository->findAll();
        // $types = $userRepository->findBy([],['id' =>'desc']);

        // Je crée ma recherche puis je lui donne une valeur
        return $this->render('user/adminUser.html.twig', [
            // je crée la variable Twig 'course'  que j'irai appeler dans mon fichier Twig Home.html.twig
            'users' => $users
        ]);
    }
    /**
     * @Route("/user_create", name="user_create")
     */

    public function userCreate(Request $request,
                                UserPasswordEncoderInterface $passwordEncoder,
                                GuardAuthenticatorHandler $guardAuthenticatorHandler,
                                UserAuthenticator $authenticator,
                                Response $response,
                                UserRepository $userRepository,
                                EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
       // $form->handleRequest($request);
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

            $this->addFlash('success', 'Email envoyé, merci pour votre inscription');
            $this->redirectToRoute('home');

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('administrateur@dropshipresource.com', 'DropshipResource'))
                    ->to($user->getEmail())
                    ->subject('Confirmation email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('user/userCreate.html.twig', [
            'registrationForm' => $form->createView(),
        ]);

        // $user = new User();
        // j'instancie un nouvel utilisateur et je lui donne la variable $user
       // $userForm = $this-> createForm(UserType::class, $user);
        // je récupère le gabarit du formulaire de l'entité User,
        // créé  dans la console avec la commande make:form
        // et je le stocke dans une variable $userForm
        //$userForm->handleRequest($request);
        //Je prends les données crées et les envoie à mon formulaire

        //if ($userForm->isSubmitted() && $userForm->isValid()) {

        //    $entityManager->persist($user);
            // J'enregistre le nouvel utilisateur
        //    $entityManager->flush();
            //je sauvegarde la nouvelle donnée

        //    $this->addFlash('success', 'Votre compte utilisateur a bien été créé');
            # Je demande l'affichage du 'message' tel qu'indiqué #}
        //    return $this->redirectToRoute('user_show');
        //}
        //return $this->render('user/userCreate.html.twig',[
        //    'userForm' => $userForm->createView(),
         //   'user' => $user]);


    }

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