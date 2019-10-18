<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminGenreController extends AbstractController
{
    /**
     * @Route("/admin/genre", name="admin_genre")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Genre::class);
        $genres = $repository->findBy([],['libelle' => 'ASC']);
        return $this->render('admin_genre/index.html.twig', [
            'lesGenres' => $genres,
        ]);
    }

    /**
     * @Route("/admin/genre/{id}", name="edit_genre", methods="GET|POST")
     */
    public function edit_genre($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Genre::class);
        $genre = $repository->find($id);
        $form=$this->createForm(GenreType::class,$genre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('succesMessage','Genre modifié avec succès');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("admin_genre");
        }
        return $this->render('admin_genre/edit.html.twig', ['leGenre'=>$genre, 'form'=>$form->createView()]);
    }

    /**
     * @Route("/admin/genre/{id}", name="delete_genre", methods="DELETE")
     */
    public function delete_genre($id, Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token')))
        {
            $this->addFlash('succesMessage','Le genre a été supprimé avec succès');
            $repository = $this->getDoctrine()->getRepository(Genre::class);
            $genre = $repository->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($genre);
            $entityManager->flush();

            return $this->redirectToRoute("admin_genre");
        }
    }

    /**
     * @Route("/genre/add", name="add_genre")
     */
    public function add_serie(Request $request)
    {
        $genre = new Genre();
        $form=$this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('succesMessage','Félicitation, L\'ajout est un succès');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($genre);
            $entityManager->flush();

            return $this->redirectToRoute("admin_genre");
        }
        return $this->render('admin_genre/add.html.twig', ['leGenre'=>$genre, 'form'=>$form->createView()]);
    }
}
