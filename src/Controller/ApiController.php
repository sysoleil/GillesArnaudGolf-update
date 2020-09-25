<?php

namespace App\Controller;

use App\Entity\Calendar;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
    /**
     * @Route("/api{id}/edit", name="api_event_edit", methods={"PUT"})
     * @param calendar|null $calendar
     * @param Request $request
     * @return Response
     */
    //Je bloque la route sur la méthode PUT cad  que si j'essai d'ouvrir via l'URL
    //il n'autorise pas la méthode GET
    // mettre à jour un enregistrement ou le créer si il n'existe pas
    //Le "?" m'autorise à passer un ID qui potentiellement n'existerait pas
    // l'inconvénient est que je dois récupérer toutes les données.

    public function majEvent(?Calendar $calendar, Request $request)
    {
        // Je demande à ce que cela me retourne une réponse
        //je récupére les données envoyées par FullCalendar
        $donnees = json_decode($request->getContent());

        //je vérifie que j'ai bien toutes les données requises
        // sauf sur 'allday' et 'sur fin de cours' et si elles ne sont pas vides

        if (
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description)
        ) {
            // données complètes
            // j'initialise le code 200 = Mis à jour
            $code = 200;

            // je vérifie l'existence de l'ID et s'il n'existe pas,
            // j'instancie un nouveau Rdv
            if (!$calendar) {
                $calendar = new Calendar;
                // le code sera alors le 201 pour créé
                $code = 201;
            }
            // j'hydrate l'objet avec l'ensemble des données
            $calendar->setTittle($donnees->title);
            $calendar->setDescription($donnees->description);
            $calendar->setStart(new DateTime($donnees->start));
            if ($donnees->allDay) {
                $calendar->setEnd(new DateTime($donnees->start));
            } else {
                $calendar->setEnd(new DateTime($donnees->end));
            }
            $calendar->setAllDay($donnees->AllDay);
            //J'aurai aussi pû faire une Ternaire (return $this)

            // Pour la données Start, je dois vérifier si allDay est true

            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            // je retourne le code
            return new Response('ok', $code);
        } else {
            //données incomplètes : message + erreur 404
            return new Response('données incomplètes', 404);
        }
        return $this->render('calendar/reservation.html.twig', [
            'controller_name' =>' ApiController',
            ]);
    }
}
