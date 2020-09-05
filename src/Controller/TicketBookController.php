<?php

namespace App\Controller;

use App\Form\TicketBookType;
use App\Entity\TicketBook;
use App\Repository\TicketBookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class TicketBookController extends AbstractController

{
    /**
     * @Route("/ticket", name="ticket_book_show")
     */

    public function ticketBookShow (TicketBookRepository $ticketBookRepository)
    {
        // je veux récupérer une instance de la variable 'TicketBookRepository $ticketBookRepository'
        //J'instancie dans la variable la class pour récupérer les valeurs requises

        // je crée ma route pour ma page de carnet de ticket

        $ticketBook = $ticketBookRepository->findAll();

        // Je crée ma recherche puis je lui donne une valeur
        return $this->render('ticket/adminTicketBookShow.html.twig',[
            // je crée la variable $ticket  que j'irai appeler dans mon fichier Twig 'ticketBookShow'
            'ticketBook' => $ticketBook
        ]);
    }
    /**
     * @Route("/ticket_insert", name="ticket_book_insert")
     */

    public function ticketBookInsert (TicketBookRepository $ticketBookRepository,
                                      Request $request,
                                      EntityManagerInterface $entityManager)
    {
        $ticketBook = new TicketBook();
        // j'instancie un nouveau type de carnet et je lui donne la variable $ticketBook
        $ticketBookForm = $this-> createForm(TicketBookType::class, $ticketBook);
        // je crée le formulaire à qui je donne la variable $ticketBookForm
        $ticketBookForm->handleRequest($request);
        //Je prends les données crées et les envoie à mon formulaire

        if ($ticketBookForm->isSubmitted() && $ticketBookForm->isValid()) {
            // je pose deux conditions avant de traiter l'information
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticketBook);
            // J'enregistre le nouveau carnet de ticket
            $entityManager->flush();
            //je sauvegarde la nouvelle donnée

            $this->addFlash('success', 'Votre carnet de ticket a bien été créé');
            # Je demande l'affichage du 'message' tel qu'indiqué #}
            return $this->redirectToRoute('ticket_book_insert');
        }
        return $this->render('ticket/adminCourseTypeInsert.html.twig',[
            'ticketBookForm' => $ticketBookForm->createView(),
            '$ticketBook' => $ticketBook]);
    }

    /**
     * @Route("/ticket_delete/{id}", name="ticket_delete")
     */

    public function ticketDelete(TicketBookRepository $ticketBookRepository,
                                 EntityManagerInterface $entityManager,
                                 $id)
    {
        $ticketBook = $ticketBookRepository->find($id);
        $entityManager->remove($ticketBook);
        $entityManager->flush();
        return $this->redirectToRoute('ticket_book_show');
    }

    /**
     * @Route("/ticket_update/{id}", name="ticket_book_update")
     */
    // je crée ma route pour ma page
    public function ticketBookUpdate(TicketBookRepository $ticketBookRepository,
                                     Request $request,
                                     EntityManagerInterface $entityManager,
                                     $id)
        // Je veux récupérer une instance de la variable 'TicketBookRepository $ticketBookRepository'
        //J'isntancie dans la variable la class pour récupérer les valeurs requises
    {
        $ticketBook = $ticketBookRepository->find($id);
        //j'appelle le carnet de ticket dans le repository 'ticketBook' avec la wildcard

        $ticketBookForm = $this->createForm(TicketBookType::class, $ticketBook);
        // je récupère le gabarit de formulaire de l'entité Cours,
        //  créé  dans la console avec la commande make:form.
        // et je le stocke dans une variable $courseForm

        if ($request->isMethod('POST')) {
            $ticketBookForm->handleRequest($request);
            //Cette méthode Request permet de récupérer les données de la méthode post
            //Je prends les données de ma requête et je les envois au formulaire
            if ($ticketBookForm->isSubmitted() && $ticketBookForm->isValid()) {

                $entityManager->persist($ticketBook);
                // la méthode persist indique de récupérer la variable $ticketBook modifiée
                $entityManager->flush();
                // la méthode 'flush' enregistre la modification
                // puis j'éxécute l'URL et je vais raffraichir ma DBB
                return $this->redirectToRoute('ticket_book_show');
            }
        }

        $this->addFlash('success', 'Votre carnet de ticket a bien été modifié');
        //J'ajoute un message flash pour confirmer la modif
        //   return $this->redirectToRoute('ticket_show');

        $ticketBookForm = $ticketBookForm->createView();
        //Je crée une nouvelle route pour instancier un nouveau cours
        return $this->render('ticket/adminTicketBookUpdate.html.twig', [
            'ticketBookForm' => $ticketBookForm
            // je retourne mon fichier twig, en lui envoyant
            // la vue du formulaire, générée avec la méthode createView()
        ]);
    }
}