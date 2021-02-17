<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController

{
    /**
     * @Route("/media", name="media")
     * @param MediaRepository $mediaRepository
     * @return Response
     */

    public function media(MediaRepository $mediaRepository)
    {
        // je veux récupérer une instance de la variable 'MediaRepository $mediaRepository...'
        //J'instancie dans la variable la class pour récupérer les valeurs requises

        // je crée ma route pour ma page de tutos

        $medias = $mediaRepository->findAll();

        // Je crée ma recherche puis je lui donne une valeur
        return $this->render('media/media.html.twig', [
            // je crée la variable Twig 'media'  que j'irai appeler dans mon fichier Twig Home.html.twig
            'medias' => $medias
        ]);
    }

    /**
     * @Route("/admin/media_insert", name="media_insert")
     * @param MediaRepository $mediaRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */

    public function mediaInsert(MediaRepository $mediaRepository,
                                Request $request,
                                EntityManagerInterface $entityManager)
    {
        $media = new Media();
        // J'instancie un nouveau média et je lui donne la valeur
        $mediaForm = $this->createForm(MediaType::class, $media);
        //Je crée le formulaire à qui je donne la variable media
        $mediaForm->handleRequest($request);
        //Je prends les données crées et les envoie à mon formulaire

        if ($mediaForm->isSubmitted() && $mediaForm->isValid()) {
            //Je prends les données de ma requête et je les envois au formulaire
            $file = $mediaForm->get('photo')->getData();
            // vu que le champs photo de mon formulaire est en mapped false
            // je gère moi même l'enregistrment de la valeur de cet input
            // j'ai au préalable indiqué le paramètre de mon upload dans mon services.yaml
            // je récupère l'image uploadée
            $filePhoto = md5(uniqid()) . '.' . $file->guessExtension();
            // je crée un numéro unique que je concatène avec l'extension de mon fichier uploadé
            $file->move(
                $this->getParameter('upload_directory'), $filePhoto);
            //l’image uploadée est déplacée.
            // Je crée le paramètre indiquant l'endroit où seront stockées mes images uploadées.
            $media->setPhoto($filePhoto);
            // je sauvegarde dans la colonne Photo le nom (unique) de mon image.
            $entityManager->persist($media);
            // la méthode persist indique de récupérer la variable media modifiée et d'insérer
            $entityManager->flush();
            // la méthode 'flush' enregistre la modification
            // puis j'éxécute l'URL et je vais raffraichir ma DBB
            return $this->redirectToRoute('media');
        }
        return $this->render('media/adminMediaInsert.html.twig', [
            'mediaForm' => $mediaForm->createView(),
            'media' => $media]);
    }

    /**
     * @Route("/admin/media_delete/{id}", name="media_delete")
     * @param MediaRepository $mediaRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return RedirectResponse
     */

    public function mediaDelete(MediaRepository $mediaRepository,
                                EntityManagerInterface $entityManager,
                                $id)
    {
        $media = $mediaRepository->find($id);
        $entityManager->remove($media);
        $entityManager->flush();
        return $this->redirectToRoute('media');
    }

    /**
     * @Route("/admin/media_update/{id}", name="media_update")
     * @param MediaRepository $mediaRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return RedirectResponse|Response
     */

    public function mediaUpdate(MediaRepository $mediaRepository,
                                Request $request,
                                EntityManagerInterface $entityManager,
                                $id)
        // Je veux récupérer une instance de la variable 'MediaRepository $mediaRepository'
        //J'isntancie dans la variable la class pour récupérer les valeurs requises
        //Cette méthode Request permet de récupérer les données de la méthode post
    {
        $media = $mediaRepository->find($id);
        // j'appelle le media dans le repository media avec la wilcdard

        $mediaForm = $this->createForm(MediaType::class, $media);
        // je récupére le gabarit du formulaire (créé ds la console avec make:form)
        // et je le stocke dans la variable $mediaForm

        if ($request->isMethod('POST')) {
            $mediaForm->handleRequest($request);
            //Je prends les données de ma requête et je les envois au formulaire
            if ($mediaForm->isSubmitted() && $mediaForm->isValid()) {
                $file = $mediaForm->get('photo')->getData();
                // vu que le champs photo de mon formulaire est en mapped false
                // je gère moi même l'enregistrment de la valeur de cet input
                // j'ai au préalable indiqué le paramètre de mon upload dans mon services.yaml
                // je récupère l'image uploadée
                $filePhoto = md5(uniqid()) . '.' . $file->guessExtension();
                // je crée un numéro unique que je concatène avec l'extension de mon fichier uploadé
                $file->move(
                    $this->getParameter('upload_directory'), $filePhoto);
                //l’image uploadée est déplacée.
                // Je crée le paramètre indiquant l'endroit où seront stockées mes images uploadées.
                $media->setPhoto($filePhoto);
                // je sauvegarde dans la colonne Photo le nom (unique) de mon image.
                $entityManager->persist($media);
                // la méthode persist indique de récupérer la variable media modifiée et d'insérer
                $entityManager->flush();
                // la méthode 'flush' enregistre la modification
                // puis j'éxécute l'URL et je vais raffraichir ma DBB
                return $this->redirectToRoute('media');
            }
        }
        $this->addFlash('success', 'Votre tuto a bien été modifié');
        //J'ajoute un message flash pour confirmer la modif

        $form = $mediaForm->createView();
        //Je crée une nouvelle route pour instancier un nouveau cours
        return $this->render('media/adminMediaUpdate.html.twig', [
            'mediaForm' => $form
            // je retourne mon fichier twig, en lui envoyant
            // la vue du formulaire, générée avec la méthode createView()
        ]);
    }
    /**
     * @Route("media/show/{id}", name="media_show")
     * @param MediaRepository $mediaRepository
     * @param $id
     * @return Response
     */

    public function mediaShow(MediaRepository $mediaRepository,
                              $id)
    {
        $media = $mediaRepository->find($id);
        return $this->render('media/mediaShow.html.twig',[
            'media' => $media
            ]);
    }

}