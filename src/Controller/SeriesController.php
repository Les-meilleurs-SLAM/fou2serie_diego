<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;
use App\Entity\Genre;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class SeriesController extends AbstractController
{
    /**
     * @Route("/series", name="series")
     */
    public function index()
    {
        return $this->render('series/index.html.twig', [
            'controller_name' => 'SeriesController',
        ]);
    }

    /**
    * @Route("/series", name="series")
    */
    public function series(Request $request, PaginatorInterface $paginator)
    {
        $repository = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $repository->findBy([],['titre' => 'ASC']);
        $serie=$paginator->paginate(
            $serie,
            $request->query->getInt('Page',1),
            2
        );
        return $this->render('home/series.html.twig', ['lesSeries'=>$serie]);
    }

    /**
    * @Route("/infoSerie/{id}", name="infoSerie")
    */
    public function infoSerie($id)
    {
        $repository = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $repository->InfoSerie($id);
        return $this->render('home/infosSerie.html.twig', ['lesSeries'=>$serie]);
    }

    /**
    * @Route("/associerGenres", name="associerGenres")
    */
    public function associerGenres()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $repositorySerie=$entityManager->getRepository(Serie::class);
        $serie=$repositorySerie->find(3);

        $repositoryGenre=$entityManager->getRepository(Genre::class);
        $genre=$repositoryGenre->find(5);

        $serie->addGenre($genre);

        $entityManager->flush();

        return new Response("association effectuée");
    }
}
