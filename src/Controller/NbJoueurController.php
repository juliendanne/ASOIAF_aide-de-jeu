<?php

namespace App\Controller;

use App\Entity\NbJoueur;
use App\Form\NbJoueurType;
use App\Repository\NbJoueurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nb/joueur")
 */
class NbJoueurController extends AbstractController
{
    /**
     * @Route("/", name="app_nb_joueur_index", methods={"GET"})
     */
    public function index(NbJoueurRepository $nbJoueurRepository): Response
    {
        return $this->render('nb_joueur/index.html.twig', [
            'nb_joueurs' => $nbJoueurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_nb_joueur_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NbJoueurRepository $nbJoueurRepository): Response
    {
        $nbJoueur = new NbJoueur();
        $form = $this->createForm(NbJoueurType::class, $nbJoueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nbJoueurRepository->add($nbJoueur, true);

            return $this->redirectToRoute('app_nb_joueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nb_joueur/new.html.twig', [
            'nb_joueur' => $nbJoueur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_nb_joueur_show", methods={"GET"})
     */
    public function show(NbJoueur $nbJoueur): Response
    {
        return $this->render('nb_joueur/show.html.twig', [
            'nb_joueur' => $nbJoueur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_nb_joueur_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NbJoueur $nbJoueur, NbJoueurRepository $nbJoueurRepository): Response
    {
        $form = $this->createForm(NbJoueurType::class, $nbJoueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nbJoueurRepository->add($nbJoueur, true);

            return $this->redirectToRoute('app_nb_joueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nb_joueur/edit.html.twig', [
            'nb_joueur' => $nbJoueur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_nb_joueur_delete", methods={"POST"})
     */
    public function delete(Request $request, NbJoueur $nbJoueur, NbJoueurRepository $nbJoueurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nbJoueur->getId(), $request->request->get('_token'))) {
            $nbJoueurRepository->remove($nbJoueur, true);
        }

        return $this->redirectToRoute('app_nb_joueur_index', [], Response::HTTP_SEE_OTHER);
    }
}
