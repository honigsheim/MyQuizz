<?php

namespace App\Controller;


use App\Entity\User;

use App\Form\UserAdminType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user/", name="user")
     */
    public function index(UserRepository $user)
    {
        $user = $user->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $user,
        ]);
    }

    /**
     * @Route("user/new", name="user_new")
     * @Route("user/{id}/edit", name="user_edit")
     */
    public function new(Request $request,User $user=null, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        if(!$user){
            $user = new User();

        }
        

        $form = $this->createForm(UserAdminType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user');
        }
        return $this->render('user/create_user.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'editMode'=> $user->getId() !==null
            
        ]);
    }
    /**
     * @Route("user/{id}", name="user_show")
     */
    public function show(User $user)
    {
        return $this->render('user/show.html.twig',[
            'user' => $user
         ]);
    }
   
    /**
     * @Route("user/{id}/", name="user_delete", methods="DELETE")
     */
    public function delete(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        
        return $this->redirectToRoute('user');
    }
}
