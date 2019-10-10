<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Genre;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class GenreController extends AbstractController
{
    /**
     * @Route("/genres", name="genres")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Genre::class);
        $genres = $repository->findBy([],['libelle' => 'ASC']);
        return $this->render('home/genres.html.twig', ['lesGenres'=>$genres]);
    }

    /**
    * @Route("/infoGenre/{id}", name="infoGenre")
    */
    public function infoGenre($id, Request $request, PaginatorInterface $paginator)
    {
        $repository = $this->getDoctrine()->getRepository(Genre::class);
        $genre = $repository->find($id);
        $lesSeries=$genre->getlesSeries();
        $lesSeries = $paginator->paginate(
            $lesSeries, 
            $request->query->getInt('page', 1), 
            1 
        );
        return $this->render('home/series.html.twig', ['lesSeries'=>$lesSeries]);
    }

    /**
    * @Route("/loadGenres", name="loadGenres")
    */
    public function loadGenres()
    {
        //Liste des genres à ajouter
        $noms = array('action', 'policier', 'aventure');
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($noms as $i => $nom) {
            // on crée un tableau avec les objets Genre
            $liste_genre[$i] = new Genre();
            $liste_genre[$i]->setLibelle($nom);
            // On persiste la liste
            $entityManager->persist($liste_genre[$i]);
        }
        // On déclenche l'enregistrement
        $entityManager->flush();

        return new Response("ajout effectué");
    }

}
