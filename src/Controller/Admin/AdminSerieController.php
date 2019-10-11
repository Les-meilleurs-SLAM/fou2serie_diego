<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;
use App\Form\SerieType;

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
    public function edit_serie($id)
    {
        $repository = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $repository->find($id);
        $form=$this->createForm(SerieType::class,$serie);
        return $this->render('admin/admin_serie/edit.html.twig', ['laSerie'=>$serie, 'form'=>$form->createView()]);
    }
}
