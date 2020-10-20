<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */

    public function home()
    {
        return $this->render('commons/home.html.twig');
    }

    /**
     * @Route("/cal", name="cal_home")
     * @param CalendarRepository $calendar
     * @return Response
     */

    public function index(CalendarRepository $calendar)
    {
        $events = $calendar->findAll();

        // les date sont en dateTime je vais donc les transformer directement
        // en Array pour les envoyer ensuite à ma vue

        // j'initialise un tableau vide que je nomme
        $rdvs = [];

        foreach($events as $event){
            $rdvs[]=[
                //je récupère les 'events' dans un array vide
                'id' => $event->getId(),
                // je précise le format me permettant de récupérer la date au bon format
                'start' => $event->getStart()->format("Y-m-d\TH:i:sP"),
                'end' => $event->getEnd()->format("Y-m-d\TH:i:sP"),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'allDay' => $event->getAllDay(),
            ];
        }
        $data = json_encode($rdvs);
        // je passe mes données 'data' à ma vue avec 'compact'
        return $this->render('calendar/reservation.html.twig', compact('data'));
    }
}