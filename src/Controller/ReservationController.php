<?php

namespace App\Controller;


use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ReservationController extends AbstractController

{
    /**
     * @Route("/resa", name="resa")
     */

    public function reservation ( )
    {
        // je veux récupérer une instance de la variable 'ReservationController $reservationController'
        //J'instancie dans la variable la class pour récupérer les valeurs requises

        // je crée ma route pour ma page de reservations

     //   $reservation = $reservationRepository->findAll();
        // $types = $userCourseRepository->findBy([],['id' =>'desc']);

        // Je crée ma recherche puis je lui donne une valeur
        return $this->render('reservation/reservation.html.twig',[
            // je crée la variable Twig '$userCourse'  que j'irai appeler dans mon fichier Twig Home.html.twig
            'contoller_name' => 'ReservationController',
        ]);
    }
 //   /**
 //    * @Route("/reservation_insert", name="reservation_insert")
 //    */

    public function reservationInsert (ReservationRepository $reservationRepository,
                                      Request $request,
                                      EntityManagerInterface $entityManager)
    {
        $reservation = new Reservation();
        // j'instancie une nouvelle réservation de cours et je lui donne la variable $reservation
        $reservationForm = $this-> createForm(ReservationType::class,$reservation);
        // je crée le formulaire à qui je donne la variable $reservationForm
        $reservationForm->handleRequest($request);
        //Je prends les données crées et les envoie à mon formulaire

        if ($reservationForm->isSubmitted() && $reservationForm->isValid()) {
            // je pose deux conditions avant de traiter l'information
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            // J'enregistre la nouvelle réservation de cours
            $entityManager->flush();
            //je sauvegarde la nouvelle donnée

            $this->addFlash('success', 'Votre réservation a bien été enregistrée');
            # Je demande l'affichage du 'message' tel qu'indiqué #}
            return $this->redirectToRoute('reservation');
        }
        return $this->render('reservation/reservationInsert.html.twig',[
            'reservationForm' => $reservationForm->createView(),
            'reservation' => $reservation]);
    }

    /**
     * @Route("/reservation_delete/{id}", name="reservation_delete")
     * @param ReservationRepository $reservationRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return RedirectResponse
     */

    public function reservationDelete(ReservationRepository $reservationRepository,
                                     EntityManagerInterface $entityManager,
                                     $id)
    {
        $reservation = $reservationRepository->find($id);
        $entityManager->remove($reservation);
        $entityManager->flush();
        return $this->redirectToRoute('reservation');
    }

    /**
     * @Route("/reservation_update/{id}", name="reservation_update")
     * @param ReservationRepository $reservationRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return RedirectResponse|Response
     */
    // je crée ma route pour ma page
    public function reservationUpdate(ReservationRepository $reservationRepository,
                                     Request $request,
                                     EntityManagerInterface $entityManager,
                                     $id)
        // Je veux récupérer une instance de la variable 'ReservationRepository $reservationRepository'
        //J'isntancie dans la variable la class pour récupérer les valeurs requises
        //Cette méthode Request permet de récupérer les données de la méthode post
    {
        $reservation = $reservationRepository->find($id);
        //j'appelle la réservation des cours dans le repository reservation avec la wildcard

        $reservationForm = $this->createForm(ReservationType::class, $reservation);
        // je récupère le gabarit de formulaire de l'entité reservation,
        //  créé  dans la console avec la commande make:form.
        // et je le stocke dans une variable $reservationForm

        if ($request->isMethod('POST')) {
            $reservationForm->handleRequest($request);

            //Je prends les données de ma requête et je les envois au formulaire
            if ($reservationForm->isSubmitted() && $reservationForm->isValid()) {
                $entityManager->persist($reservation);
                // la méthode persist indique de récupérer la variable userCourse modifiée
                $entityManager->flush();
                // la méthode 'flush' enregistre la modification
                // puis j'éxécute l'URL et je vais raffraichir ma DBB
                return $this->redirectToRoute('reservation');
            }
        }

        $this->addFlash('success', 'Votre réservation a bien été modifiée');
        //J'ajoute un message flash pour confirmer la modif

        $form = $reservationForm->createView();
        //Je crée une nouvelle route pour instancier une nouvelle réservation
        return $this->render('reservation/adminReservationInsert.html.twig', [
            'reservationForm' => $form
            // je retourne mon fichier twig, en lui envoyant
            // la vue du formulaire, générée avec la méthode createView()
        ]);
    }

    /**
     * @Route("/admin/reservation_show/{id}", name="admin_reservation_show")
     * @param ReservationRepository $reservationRepository
     * @param $id
     * @return Response
     */

    public function adminReservationShow(ReservationRepository $reservationRepository, $id)
    {
        $reservation = $reservationRepository->find($id);
        return $this->render('reservation/adminReservationShow.html.twig',[
            'reservation' => $reservation
        ]);
    }
}