<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use Doctrine\ORM\Query\Expr\OrderBy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/calendar")
 */
class CalendarController extends AbstractController
{
    /**
     * @Route("/", name="calendar_index", methods={"GET"})
     * @param CalendarRepository $calendarRepository
     * @return Response
     */
    public function index(CalendarRepository $calendarRepository): Response
    {
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findBy([],['start' =>'DESC'])
        ]);
    }

    /**
     * @Route("/new", name="calendar_new", methods={"GET","POST"})
     * @param Request $request
     * @param CalendarRepository $calendarRepository
     * @return Response
     */
    public function new(Request $request,CalendarRepository $calendarRepository): Response
    {

        // j'instancie une nouvelle réservation de cours et je lui donne la variable $reservation
        $reservation = new Calendar();
        // je crée le formulaire à qui je donne la variable $Form
        $form = $this->createForm(CalendarType::class, $reservation);
        //Je prends les données crées et les envoie à mon formulaire
        $form->handleRequest($request);

        // je pose 2 conditions avant de traiter l'information

        if($reservation === null) {
            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();
                // J'enregistre la nouvelle réservation de cours
                $entityManager->persist($reservation);
                //je sauvegarde la nouvelle donnée
                $entityManager->flush();

                return $this->redirectToRoute('cal_home');
            } else {
                $this->addFlash('message', "Ce créneau n'est pas disponible");
            }
        }return $this->render('calendar/new.html.twig', [
            'calendar' => $reservation,
            'calendarForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calendar_show", methods={"GET"})
     * @param Calendar $calendar
     * @return Response
     */
    public function show(Calendar $calendar): Response
    {
        return $this->render('calendar/show.html.twig', [
            'calendar' => $calendar,
        ]);
    }

    /**
     * @Route("/{id}/update", name="calendar_update", methods={"GET","POST"})
     * @param Request $request
     * @param Calendar $calendar
     * @return Response
     */
    // Je veux récupérer une instance de la variable 'ReservationRepository $reservationRepository'
    //J'isntancie dans la variable la class pour récupérer les valeurs requises
    //Cette méthode Request permet de récupérer les données de la méthode post
    public function edit(Request $request, Calendar $calendar): Response
    {   // je récupère le gabarit de formulaire de l'entité reservation,
        //  créé  dans la console avec la commande make:form.
        // et je le stocke dans une variable $Form
        $form = $this->createForm(CalendarType::class, $calendar);
        //Je prends les données de ma requête et je les envois au formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            // la méthode 'flush' enregistre la modification
            // puis j'éxécute l'URL et je vais raffraichir ma DBB
            return $this->redirectToRoute('cal_home');
        }
        //J'ajoute un message flash pour confirmer la modif
        $this->addFlash('success', 'Votre réservation a bien été modifiée');

        // je retourne mon fichier twig, en lui envoyant
        // la vue du formulaire, générée avec la méthode createView()
        return $this->render('calendar/calendarUpdate.html.twig', [
            'calendar' => $calendar,
            'calendarForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calendar_delete", methods={"DELETE"})
     * @param Request $request
     * @param Calendar $calendar
     * @return Response
     */
    public function delete(Request $request, Calendar $calendar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$calendar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($calendar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cal_home');
    }

 //   /**
 //    * @Route("/calendar_user, name="calendar_user")
 //    * @param CalendarRepository $calendarRepository
 //    * @param UserRepository $userRepository
 //    * @param Request $request
 //    * @return Response
 //    */
 //   public function getCalendarByLastName(CalendarRepository $calendarRepository,
 //                                         Request $request,
 //                                         UserRepository $userRepository): Response
 //   {
 //       $start = $request->query->get('start');
 //       $lastName = $request->query->get('lastName');
//
 //       $calendar = $calendarRepository->getCalendarByLastName($lastName, $start);
//
 //       return $this->render('calendar/new_this.html.twig', ['lastName' => $lastName]);
 //   }
}
