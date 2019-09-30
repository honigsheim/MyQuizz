<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Form\QuizType;
use App\Entity\Reponse;
use App\Entity\Question;

use App\Entity\Reponses;
use App\Entity\Categorie;
use App\Form\ReponseType;
use App\Form\QuestionType;

use App\Form\CategorieType;
use App\Repository\QuizRepository;
use App\Repository\ReponseRepository;
use App\Repository\ReponsesRepository;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class QuizController extends AbstractController
{
    /**
     * @Route("/categorie/{id}", name="categorie_quiz")
     */
    public function index(QuizRepository $repo, $id)
    {
     
       
         $quizs = $repo->findBy(
            ['categorie' => $id]
        );
  
        return $this->render('quiz/index.html.twig',[
            'quizs' => $quizs
        ]);
    }

      /**
     * @Route("/list/{id}", name="list")
     */
    public function list(QuizRepository $Quizz, $id) {
       
        return $this->render('quiz/list.html.twig', [
            "dataQuizz" => $dataQuizz
        ]);
    }

    /**
     * @Route("/", name="home")
     */

    public function home()
    {
        return $this->render('quiz/home.html.twig');
    }
    

  

    /**
     * @Route("/quiz/new", name="quiz_create")
     * @Route("/quiz/{id}/edit", name="quiz_edit")
     */

    public function form(Quiz $quiz = null, Request $request, objectManager $manager)
    {
   
        $quiz = new Quiz();
        $formQuiz = $this->createForm(QuizType::class,$quiz);
      
        $formQuiz->handleRequest($request);

        if($formQuiz->isSubmitted()&& $formQuiz->isValid()) {
            $manager->persist($quiz);
            $manager->flush();
            return $this->redirectToRoute('quiz_question_create',['id'=> $quiz->getId()]);
        }

            return $this->render('quiz/create.html.twig',[
            'formQuiz' => $formQuiz->createView(),
            'quiz' => $quiz->getId() == null,
           
        ]);
       
    }

      /**
     * @Route("/quiz/{id}", name="quiz_show")
     */

    public function show(Quiz $quiz, Request $request, ReponsesRepository $reponses)
    {
        $message = '';
        $rep = $request->get('rep');
        $compteur = $request->get('next');
        $bonneRep = $request->get('bonneRep');

        if (!isset($compteur)){
            $compteur = 0;
        } else {
            $compteur += 0.5;
            dump($compteur);
        }
        if (!isset($bonneRep)){
            $bonneRep = 0;
        }
        if (isset($rep)) {
            $reponses = $reponses->findAll();
            $rep--;
            $reponses = $reponses[$rep]->getReponseExpected();
            if ($reponses === true) {
                $message = "Bonne réponse !";
                $bonneRep++;
            } else {
                $message = "Dommage ! La bonne réponse est : " ;
            }
        }
        if ($compteur == 10) {
            return $this->render('quiz/result.html.twig',[
                "bonneRep" => $bonneRep
            ]);
        }

        return $this->render('quiz/show.html.twig',[
            'quiz'=> $quiz,
            "message" => $message,
            "compteur" => $compteur,
            "rep" => $request->get('rep'),
            "next" => $request->get('next'),
            "bonneRep" => $bonneRep,
            "yes" => $reponses,
           
        ]);
    }



   
}
