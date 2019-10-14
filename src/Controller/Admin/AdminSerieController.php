<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;
use App\Form\SerieType;
use Symfony\Component\HttpFoundation\Request;

class AdminSerieController extends AbstractController
{
    /**
     * @Route("/admin/serie", name="admin_serie")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $repository->findBy([],['titre' => 'ASC']);
        return $this->render('admin/admin_serie/index.html.twig', ['lesSeries'=>$serie]);
    }

    /**
     * @Route("/admin/{id}", name="edit_serie")
     */
    public function edit_serie($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $repository->find($id);
        $form=$this->createForm(SerieType::class,$serie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("admin_serie");
        }
        return $this->render('admin/admin_serie/edit.html.twig', ['laSerie'=>$serie, 'form'=>$form->createView()]);
    }

    /**
     * @Route("/delete/{id}", name="delete_serie")
     */
    public function delete_serie($id)
    {
        $repository = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $repository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->redirectToRoute("admin_serie");
    }

    /**
     * @Route("/add", name="add_serie")
     */
    public function add_serie(Request $request)
    {
        $serie = new Serie();
        $form=$this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($serie);
            $entityManager->flush();

            return $this->redirectToRoute("admin_serie");
        }
        return $this->render('admin/admin_serie/add.html.twig', ['laSerie'=>$serie, 'form'=>$form->createView()]);
    }
}
