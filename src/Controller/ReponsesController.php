<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\Reponses;

use App\Form\ReponseType;
use App\Form\ReponsesType;
use App\Repository\QuizRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReponsesController extends AbstractController
{
    /**
     * @Route("/reponses", name="reponses")
     */
    public function index()
    {
        return $this->render('reponses/index.html.twig', [
            'controller_name' => 'ReponsesController',
        ]);
    }


    /**
     * @Route("/reponse/new/{id}", name="reponse_new")
     * 
     */
    public function createReponse(Request $request, Question $question, QuizRepository $repo,objectManager $manager){
    
        $req=$request->request->get('reponses');
        $quiz= $question->getQuiz();
        $nbrQuestion = $quiz->getQuestions()->count();
     

        $reponse = new Reponses;
        $reponse2= new Reponses;
        $reponse3= new Reponses;
        
        $formReponse = $this->createForm(ReponsesType::class,$reponse);
        
        $formReponse->handleRequest($request);
        // $formReponse['reponse_expected2']->getData();
      
         
        if( $formReponse->isSubmitted()&& $formReponse->isValid()){
            
            $reponse->setQuestion($question);
            $reponse2->setQuestion($question);
            $reponse3->setQuestion($question);
          
            $reponse2->setReponseExpected($formReponse['reponse_expected2']->getData());
            $reponse2->setReponse($req['reponse2']);

            $reponse3->setReponseExpected($formReponse['reponse_expected3']->getData());
            $reponse3->setReponse($req['reponse3']);

            $manager->persist($reponse);
            $manager->persist($reponse3);
            $manager->persist($reponse2);
            $manager->flush();

            if($nbrQuestion == 10) {
                    return $this->redirectToRoute('quiz_show',['id'=> $quiz->getId()]);
            }else{
                 return $this->redirectToRoute('quiz_question_create',['id'=> $quiz->getId()]);

            }
        }

            return $this->render('reponses/reponse.html.twig',[
            'formReponse' => $formReponse->createView(),
            'question' => $question
            ]);
    }

}
