<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Quiz;
use App\Entity\Categorie;
use App\Entity\Question;

use App\Repository\CategorieRepository;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
  public function index(CategorieRepository $repo)
    {
        $categories = $repo->findAll();
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories
        ]);
    }

  



}
