<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ActualityController extends AbstractController
{
    /**
     * @Route("/actuality", name="actuality")
     * @param MediaRepository $mediaRepository
     * @return Response
     */

    public function actuality(MediaRepository $mediaRepository)
    {
    $actualities = $mediaRepository->findAll();
    return $this->render('actuality\actuality.html.twig',[
        'actualities' =>$actualities
    ]);

    }
}

