<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CourseController extends AbstractController

{
    /**
     * @Route("/cours", name="course")
     */

    public function courseList (CourseRepository $courseRepository)
    {
        // je veux récupérer une instance de la variable 'CourseRepository $courseRepository...'
        //J'instancie dans la variable la class pour récupérer les valeurs requises

        // je crée ma route pour ma page de services

        $courses = $courseRepository->findAll();
        // $types = $courseTypeRepository->findBy([],['id' =>'desc']);

        // Je crée ma recherche puis je lui donne une valeur
        return $this->render('course/course.html.twig',[
            // je crée la variable Twig 'course'  que j'irai appeler dans mon fichier Twig Home.html.twig
            'courses' => $courses
        ]);
    }
    /**
     * @Route("/cours_insert", name="course_insert")
     */

    public function courseInsert (CourseRepository $courseRepository,
                                  Request $request,
                                  EntityManagerInterface $entityManager)
    {
        $course = new Course();
        // j'instancie un nouveau cours et je lui donne la variable $course
        $courseForm = $this-> createForm(CourseType::class, $course);
        // je crée le formulaire à qui je donne la variable $courseForm
        $courseForm->handleRequest($request);
        //Je prends les données crées et les envoie à mon formulaire

        if ($courseForm->isSubmitted() && $courseForm->isValid()) {
            // je pose deux conditions avant de traiter l'information
            $file = $courseForm->get('photo')->getData();
            $filePhoto = md5(uniqid()).'.'.$file->guessExtension();
            // je crée un numéro unique que je concatène avec l'extension de mon fichier uploadé
            $file->move($this->getParameter('upload_directory'), $filePhoto);
            //l’image uploadée est déplacée.
            // Je crée le paramètre indiquant l'endroit où seront stockées mes images uploadées.
            $course->setPhoto($filePhoto);
            // je sauvegarde dans la colonne Photo le nom (unique) de mon image.

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($course);
            // J'enregistre le nouveau cours
            $entityManager->flush();
            //je sauvegarde la nouvelle donnée

            $this->addFlash('success', 'Votre cours a bien été créé');
            # Je demande l'affichage du 'message' tel qu'indiqué #}
            return $this->redirectToRoute('course');
        }
        return $this->render('course/adminCourseInsert.html.twig',[
            'courseForm' => $courseForm->createView(),
            'course' => $course]);
    }

    /**
     * @Route("/course_delete/{id}", name="course_delete")
     */

    public function courseDelete(CourseRepository $courseRepository,
                                 EntityManagerInterface $entityManager,
                                 $id)
    {
        $course = $courseRepository->find($id);
        $entityManager->remove($course);
        $entityManager->flush();
        return $this->redirectToRoute('course');
    }

    /**
     * @Route("/cours_update/{id}", name="course_update")
     */
    // je crée ma route pour ma page
    public function courseUpdate(CourseRepository $courseRepository,
                                 Request $request,
                                 EntityManagerInterface $entityManager,
                                 $id)
        // Je veux récupérer une instance de la variable 'CourseRepository $courseRepository'
        //J'isntancie dans la variable la class pour récupérer les valeurs requises
        //Cette méthode Request permet de récupérer les données de la méthode post
    {
        $course = $courseRepository->find($id);
        //j'appelle le cours dans le repository cours avec la wildcard

        $courseForm = $this->createForm(CourseType::class, $course);
        // je récupère le gabarit de formulaire de l'entité Cours,
        //  créé  dans la console avec la commande make:form.
        // et je le stocke dans une variable $courseForm

        if ($request->isMethod('POST')) {
            $courseForm->handleRequest($request);

            //Je prends les données de ma requête et je les envois au formulaire
            if ($courseForm->isSubmitted() && $courseForm->isValid()) {
                $file = $courseForm->get('photo')->getData();
                $filePhoto = md5(uniqid()).'.'.$file->guessExtension();
                // je crée un numéro unique que je concatène avec l'extension de mon fichier uploadé
                $file->move($this->getParameter('upload_directory'), $filePhoto);
                //l’image uploadée est déplacée.
                // Je crée le paramètre indiquant l'endroit où seront stockées mes images uploadées.
                $course->setPhoto($filePhoto);
                // je sauvegarde dans la colonne Photo le nom (unique) de mon image.

                $entityManager->persist($course);
                // la méthode persist indique de récupérer la variable Course modifiée et d'insérer
                $entityManager->flush();
                // la méthode 'flush' enregistre la modification
                // puis j'éxécute l'URL et je vais raffraichir ma DBB
                return $this->redirectToRoute('course');
            }
        }

        $this->addFlash('success', 'Votre cours a bien été modifié');
        //J'ajoute un message flash pour confirmer la modif
        //   return $this->redirectToRoute('course');

        $form = $courseForm->createView();
        //Je crée une nouvelle route pour instancier un nouveau cours
        return $this->render('course/adminCourseUpdate.html.twig', [
            'courseForm' => $form
            // je retourne mon fichier twig, en lui envoyant
            // la vue du formulaire, générée avec la méthode createView()
        ]);
    }
    /**
     * @Route("/cours_show/{id}", name="course_show")
     */

    public function courseShow(CourseRepository $courseRepository, $id)
    {
        $course = $courseRepository->find($id);
        return $this->render('course/courseShow.html.twig',[
            'course' => $course
        ]);
    }
}