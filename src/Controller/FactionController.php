<?php

namespace App\Controller;

use App\Entity\Faction;
use App\Form\FactionType;
use App\Repository\FactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/faction")
 */
class FactionController extends AbstractController
{
    /**
     * @Route("/", name="app_faction_index", methods={"GET"})
     */
    public function index(FactionRepository $factionRepository): Response
    {   
        return $this->render('faction/index.html.twig', [
            'factions' => $factionRepository->findAll(),
            
        ]);
    }

    /**
     * @Route("/new", name="app_faction_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FactionRepository $factionRepository): Response
    {
        
        $faction = new Faction();
        $form = $this->createForm(FactionType::class, $faction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $factionRepository->add($faction, true);

            return $this->redirectToRoute('app_faction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('faction/new.html.twig', [
            'faction' => $faction,
            'form' => $form,
            
        ]);
    }

    /**
     * @Route("/{id}", name="app_faction_show", methods={"GET"})
     */
    public function show(Faction $faction): Response
    {
        
        return $this->render('faction/show.html.twig', [
            'faction' => $faction,
            
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_faction_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Faction $faction, FactionRepository $factionRepository): Response
    {
        
        $form = $this->createForm(FactionType::class, $faction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $factionRepository->add($faction, true);

            return $this->redirectToRoute('app_faction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('faction/edit.html.twig', [
            'faction' => $faction,
            'form' => $form,
            
        ]);
    }

    /**
     * @Route("/{id}", name="app_faction_delete", methods={"POST"})
     */
    public function delete(Request $request, Faction $faction, FactionRepository $factionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$faction->getId(), $request->request->get('_token'))) {
            $factionRepository->remove($faction, true);
        }

        return $this->redirectToRoute('app_faction_index', [], Response::HTTP_SEE_OTHER);
    }
}
