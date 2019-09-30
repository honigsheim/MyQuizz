<?php

namespace App\Controller;

use App\Entity\Categorie;

use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCategorieController extends AbstractController
{
    /**
     * @Route("/admin/categorie", name="admin_categorie")
     */
    public function index(CategorieRepository $categorie)
    {
        $categories = $categorie->findAll();
        return $this->render('admin_categorie/index.html.twig', [
            'categories' => $categories
        ]);
    }

     /**
     * @Route("/admin/categorie/new", name="categorie_new")
     * @Route("admin/categorie/{id}/edit", name="categorie_edit")
     */
    public function new(Request $request,Categorie $categorie=null, ObjectManager $manager)
    {
        if(!$categorie){
            $categorie = new Categorie();

        }
        

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        

            $manager->persist($categorie);
            $manager->flush();

            return $this->redirectToRoute('admin_categorie');
        }
        return $this->render('admin_categorie/create_categorie.html.twig', [
            'form' => $form->createView(),
            'categorie' => $categorie,
            'editMode'=> $categorie->getId() !==null
            
        ]);
    }
    /**
     * @Route("admin/categorie/{id}", name="categorie_show")
     */
    public function show(Categorie $categorie)
    {
        return $this->render('admin_categorie/show_categorie.html.twig',[
            'categorie' => $categorie
         ]);
    }

    /**
     * @Route("admin/categorie/{id}/", name="categorie_delete", methods="DELETE")
     */
 public function delete(Categorie $categorie )
 {
    

    $em = $this->getDoctrine()->getManager();

   foreach ($categorie->getQuestions() as $question) {
    //    foreach ($question->getReponses as $reponse ) {
    //        $em->remove($reponse);
    //    }
   
     $em->remove($question);

   }
   foreach($categorie->getQuizzes() as $quiz ) {
       $em->remove($quiz);
   }

        $em->remove($categorie);
        $em->flush();


   return $this->redirectToRoute('admin_categorie');
 }



    
}
