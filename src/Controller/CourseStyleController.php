<?php

namespace App\Controller;


use App\Entity\CourseStyle;
use App\Form\CourseStyleType;
use App\Repository\CourseStyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CourseStyleController extends AbstractController
{
    /**
     * @Route("/cours_style", name="course_style")
     */

    public function CourseStyle (CourseStyleRepository $courseStyleRepository)
    {
        // je veux récupérer une instance de la variable 'CourseStyleRepository $courseStyleRepository'
        //J'instancie dans la variable la class pour récupérer les valeurs requises

        // je crée ma route pour ma page de services

        $courseStyle = $courseStyleRepository->findAll();

        // Je crée ma recherche puis je lui donne une valeur

        return $this->render('courseStyle/adminCourseStyleShow.html.twig',[
            'courseStyle' => $courseStyle
        ]);
            // je crée la variable Twig 'courseStyle' que j'irai appeler dans mon fichier Twig
    }
    /**
     * @Route("/cours_style_insert", name="course_style_insert")
     */

    public function courseStyleInsert (CourseStyleRepository $courseStyleRepository,
                                      Request $request,
                                      EntityManagerInterface $entityManager)
    {
        $courseStyle = new CourseStyle();
        // j'instancie une nouvelle catégorie de cours et je lui donne la variable $courseStyle
        $courseStyleForm = $this-> createForm(CourseStyleType::class, $courseStyle);
        // je crée le formulaire à qui je donne la variable $courseStyleForm
        $courseStyleForm->handleRequest($request);
        //Je prends les données crées et les envoie à mon formulaire

        if ($courseStyleForm->isSubmitted() && $courseStyleForm->isValid()) {
            // je pose deux conditions avant de traiter l'information
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($courseStyle);
            // J'enregistre le nouveau style de cours
            $entityManager->flush();
            //je sauvegarde la nouvelle donnée

            $this->addFlash('success', 'Votre catégorie de cours a bien été créée');
            # Je demande l'affichage du 'message' tel qu'indiqué #}
            return $this->redirectToRoute('course_style');
        }
        return $this->render('courseStyle/adminCourseStyleInsert.html.twig',[
            'courseStyleForm' => $courseStyleForm->createView(),
            'courseStyle' => $courseStyle]);
    }

    /**
     * @Route("/course_style_delete/{id}", name="course_style_delete")
     */

    public function courseStyleDelete(CourseStyleRepository $courseStyleRepository,
                                     EntityManagerInterface $entityManager,
                                     $id)
    {
        $courseStyle = $courseStyleRepository->find($id);
        $entityManager->remove($courseStyle);
        $entityManager->flush();
        return $this->redirectToRoute('course_style');
    }

    /**
     * @Route("/cours_style_update/{id}", name="course_style_update")
     */
    // je crée ma route pour ma page
    public function courseStyleUpdate(CourseStyleRepository $courseStyleRepository,
                                     Request $request,
                                     EntityManagerInterface $entityManager,
                                     $id)
        // Je veux récupérer une instance de la variable 'CourseStyleRepository $courseStyleRepository'
        //J'isntancie dans la variable la class pour récupérer les valeurs requises
        //Cette méthode Request permet de récupérer les données de la méthode post
    {
        $courseStyle = $courseStyleRepository->find($id);
        //j'appelle le cours dans le repository catégorie de cours avec la wildcard

        $courseStyleForm = $this->createForm(CourseStyleType::class, $courseStyle);
        // je récupère le gabarit de formulaire de l'entité catégorie de Cours,
        //  créé  dans la console avec la commande make:form.
        // et je le stocke dans une variable $courseStyleForm

        if ($request->isMethod('POST')) {
            $courseStyleForm->handleRequest($request);

            //Je prends les données de ma requête et je les envois au formulaire
            if ($courseStyleForm->isSubmitted() && $courseStyleForm->isValid()) {
                $entityManager->persist($courseStyle);
                // la méthode persist indique de récupérer la variable courseStyle modifiée et d'insérer
                $entityManager->flush();
                // la méthode 'flush' enregistre la modification
                // puis j'éxécute l'URL et je vais raffraichir ma DBB
                return $this->redirectToRoute('course_style');
            }
        }

        $this->addFlash('success', 'Votre catégorie de cours a bien été modifiée');
        //J'ajoute un message flash pour confirmer la modif
        $form = $courseStyleForm->createView();
        //Je crée une nouvelle route pour instancier un nouveau cours
        return $this->render('courseStyle/adminCourseStyleUpdate.html.twig', [
            'courseStyleForm' => $form
            // je retourne mon fichier twig, en lui envoyant
            // la vue du formulaire, générée avec la méthode createView()
        ]);
    }
    //   /**
    //    * @Route("/cours_style_show/{id}", name="course_style_show")
    //   */

//    public function courseStyleShow(CourseStyleRepository $courseStyleRepository , $id)
//    {
//        $courseStyle = $courseStyleRepository->find($id);
//        return $this->render('courseStyle/courseStyleShow.html.twig',[
//            'courseStyle' => $courseStyle
//        ]);
    //   }
}