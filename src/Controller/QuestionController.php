<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Quiz;
use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Reponse;

use App\Form\CategorieType;
use App\Form\QuizType;
use App\Form\QuestionType;
use App\Form\ReponseType;

use App\Repository\QuizRepository;
use App\Repository\ReponseRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="question")
     */
    public function index()
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }
    /**
     * @Route("/quiz_question/{id}", name="quiz_question_create")
     * @Route("/quiz_question/{id}/edit", name="quiz_question_edit")
     * 
     */
    public function createQuestion(Request $request,Question $question=null,Quiz $quiz, QuizRepository $repo,objectManager $manager){

        // if(!$question){
             $question = new Question;

        // }
     
       
        $formQuestion = $this->createForm(QuestionType::class,$question);
        $formQuestion->handleRequest($request);

        if( $formQuestion->isSubmitted()&& $formQuestion->isValid()){
            

            $question->setQuiz($quiz);
            $question->setCategorie($quiz->getCategorie());
            $manager->persist($question);
            $manager->flush();

                return $this->redirectToRoute('reponse_new',['id'=> $question->getId()]);

        }
            return $this->render('quiz/question.html.twig',[
            'formQuestion' => $formQuestion->createView(),
            'question' => $question,
            'editMode' => $question->getId() !==null,
           
            ]);
    }




    // /**
    //  * @Route("/quiz_test/new", name="quiz_test_create")
    //  * @Route("/quiz_test/{id}/edit", name="quiz_test_edit")
    //  */

    // public function form(Question $question = null,Quiz $quiz = null, Request $request,Categorie $categorie= null, objectManager $manager)
    // {
  
    //     // if($request->request->count() > 0)
    //           $request=$request->request->get('question');
     
    //      if(!$categorie){
    //         $categorie = new Categorie;
        
    //     }
    //         $categorie->setName($request['Categorie']);
    //         $categorie->setImage($request['Image']);
        
    //      if(!$quiz){
    //         $quiz = new Quiz();
            
           
    //     }
    //         $quiz->setName($request['Name']);
    //         $quiz->setImage($request['Image']);
    //         $quiz->getCategorie($categorie);
     
       

    //     if(!$question) {
    //         $question = new Question; 
         
    //     }
    //         $question->setQuestion($request['Question']);
    //         $question->setCategorie($categorie);
    //         $question->setQuiz($quiz);
       


    
    //     $formQuiz = $this->createForm(QuestionType::class);
      

    //         return $this->render('quiz/test.html.twig',[
    //         'formQuiz' => $formQuiz->createView(),
    //         'editMode' => $quiz->getId() !== null
    //     ]);
   
  

    // }

}
