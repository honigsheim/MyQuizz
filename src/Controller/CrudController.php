<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CrudController extends AbstractController
{
    /**
     * @Route("/crud", name="crud")
     */
    public function index()
    {
        return $this->render('crud/index.html.twig', [
            'controller_name' => 'CrudController',
        ]);
    }
}
