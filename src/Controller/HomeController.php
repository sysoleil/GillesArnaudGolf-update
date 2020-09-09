<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     */

    public function index(CalendarRepository $calendarRepository)
    {
        $events = $calendarRepository->findAll();

        // les date sont en dateTime je vais donc les transformer directement en pour les envoyer ensuite à ma vue

        // j'initialise un tableau vide que je nomme 'rdvs'
        $rdvs = [];
        foreach ($events as $event){
            $rdvs[]=[
                'id' => $event->getId(),
                // je précise le format me permettant de récupérer la date au bon format
                'start' => $event->getStart()->format('d-m-Y H:i:s'),
                'end' => $event->getEnd()->format('d-m-Y H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'allDay' => $event->getAllDay(),
            ];
        }
        $data = json_encode($rdvs);
        // je passe mes données 'data' à ma vue avec 'compact'
        return $this->render('reservation/reservation.html.twig', compact('data'));
    }
}