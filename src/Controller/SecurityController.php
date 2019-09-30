<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/inscription", name="security_registration")
     * @Route("/inscription/{id}/edit", name="security_registration_edit")
     */
    public function registration(Request $request,User $user=null, ObjectManager $manager, UserPasswordEncoderInterface $encoder,\Swift_Mailer $mailer) {
       if(!$user){
            $user = new User();
       }
       
      

        $form = $this->createForm(RegisterType::class,$user);

        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user,$user->getPassword());

            $user->setPassword($hash);
            $user->setRoles(['ROLE_USER']);
            
            
             $message = (new \Swift_Message('Hello Email'))
                ->setFrom('amina.skendraoui@epitech.eu')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'email/registration.html.twig',
                        array('name' => $user->getUsername(),
                            'id' => $user->getId() )
                    ),
                    'text/html'
                );
            $mailer->send($message);
            

            $manager->persist($user);
            $manager->flush();

            if($user->getId() !==null){
                return $this->redirectToRoute('security_profile',[
                    'id'=> $user->getId()
                    ]);

            } else {
                 return $this->redirectToRoute('security_login');

            }


        }

        return $this->render('security/registration.html.twig',[
            'form'=> $form->createView(),
            'user'=> $user,
            'editMode'=> $user->getId() !==null
        ]);
    }

    /** 
    *@Route("/connexion", name="security_login")
    */

    public function login() {
        return $this->render('security/login.html.twig');
    }
    /** 
    *@Route("/deconnexion", name="security_logout")
    */

    public function logout() {}

         /** 
    *@Route("/profile/{id}", name="security_profile")
    */

    public function profile(User $user) 
    {
          return $this->render('security/profile.html.twig', [
            'user' => $user,
        ]);

    }




}
