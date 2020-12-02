<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController

{
    /**
     * @Route("/tuto", name="tuto")
     * @param MediaRepository $mediaRepository
     * @return Response
     */

    public function media (MediaRepository $mediaRepository)
    {
        // je veux récupérer une instance de la variable 'MediaRepository $mediaRepository...'
        //J'instancie dans la variable la class pour récupérer les valeurs requises

        // je crée ma route pour ma page de tutos

        $media = $mediaRepository->findAll();

        // Je crée ma recherche puis je lui donne une valeur
        return $this->render('media/media.html.twig',[
            // je crée la variable Twig 'media'  que j'irai appeler dans mon fichier Twig Home.html.twig
            'media' => $media
        ]);
    }
}