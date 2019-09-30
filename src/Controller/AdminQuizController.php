<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\Reponses;

use App\Form\QuizType;
use App\Repository\QuizRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminQuizController extends AbstractController
{
    /**
     * @Route("/admin/quiz", name="admin_quiz")
     */
    public function index(QuizRepository $quiz)
    {

         $quizs = $quiz->findAll();
        return $this->render('admin_quiz/index.html.twig', [
            'quizs' => $quizs
        ]);
    }


     /**
     * @Route("/admin/quiz/new", name="quiz_new")
     * @Route("/admin/quiz/{id}/edit", name="adminQuiz_edit")
     */
    public function new(Request $request,quiz $quiz=null, ObjectManager $manager)
    {
        if(!$quiz){
            $quiz = new quiz();

        }
        
        $form = $this->createForm(QuizType::class, $quiz);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($quiz);
            $manager->flush();

            return $this->redirectToRoute('quiz_question_create',['id'=> $quiz->getId()]);
        }
        return $this->render('admin_quiz/create_quiz.html.twig', [
            'formQuiz' => $form->createView(),
            'quiz' => $quiz,
            'editMode'=> $quiz->getId() !==null
            
        ]);
    }
    /**
     * @Route("/admin/quiz/{id}", name="adminQuiz_show")
     */
    public function show(Quiz $quiz)
    {
        return $this->render('admin_quiz/show_quiz.html.twig',[
            'quiz' => $quiz
         ]);
    }
  /**
     * @Route("/admin/quiz/{id}/", name="quiz_delete", methods="DELETE")
     */
 public function delete(Quiz $quiz )
 {
    

    $em = $this->getDoctrine()->getManager();

//    foreach ($quiz->getQuestions() as $question) {
//     //    dump($question->getReponses);
//     // //    foreach($question->getReponses as $reponse){
//     //        $em->remove($reponse);
//     //    }
//      $em->remove($question);
//    }
//    foreach($quiz->getCategorie() as $categorie ) {
//        $em->remove($categorie);
//    }

        $em->remove($quiz);
        $em->flush();


   return $this->redirectToRoute('admin_quiz');
 }
}
