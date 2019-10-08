<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;
//use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
    * @Route("/", name="home")
    */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Bienvenue sur Fou de Séries',
        ]);
    }

    /**
    * @Route("/news", name="news")
    */
    public function news()
    {
        $repository = $this->getDoctrine()->getRepository(Serie::class);
        $series = $repository->SerieLaPlusRecente();
        return $this->render('home/news.html.twig', ['lesSeries' => $series]);
    }

    /**
    * @Route("/series", name="series")
    */
    public function series()
    {
        return $this->render('App\Controller\SeriesController.php');
    }

    /**
    * @Route("/testEntity", name="testEntity")
    */
    public function testEntity()
    {
        $serie=new Serie();

        $serie->setTitre("Titre1");
        $serie->setResume("Resume1");
        $serie->setDuree(new \DateTime("00:45:00"));
        $serie->setPremiereDiffusion(new \DateTime("25-10-2005"));
        $serie->setImage("image.jpg");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($serie);
        $entityManager->flush();

        //return new Response("La série a bien été enregistrée ".$serie->getID());
        return $this->render('home/testEntity.html.twig', ['laSerie' => $serie]);
    }
}
