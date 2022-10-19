<?php

namespace App\Controller;

use App\Entity\TournamentGame;
use App\Form\TournamentGameType;
use App\Repository\TournamentGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tournament/game")
 */
class TournamentGameController extends AbstractController
{
    /**
     * @Route("/", name="app_tournament_game_index", methods={"GET"})
     */
    public function index(TournamentGameRepository $tournamentGameRepository): Response
    {
        return $this->render('tournament_game/index.html.twig', [
            'tournament_games' => $tournamentGameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_tournament_game_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TournamentGameRepository $tournamentGameRepository): Response
    {
        $tournamentGame = new TournamentGame();
        $form = $this->createForm(TournamentGameType::class, $tournamentGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tournamentGameRepository->add($tournamentGame, true);

            return $this->redirectToRoute('app_tournament_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tournament_game/new.html.twig', [
            'tournament_game' => $tournamentGame,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tournament_game_show", methods={"GET"})
     */
    public function show(TournamentGame $tournamentGame): Response
    {
        return $this->render('tournament_game/show.html.twig', [
            'tournament_game' => $tournamentGame,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_tournament_game_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TournamentGame $tournamentGame, TournamentGameRepository $tournamentGameRepository): Response
    {
        $form = $this->createForm(TournamentGameType::class, $tournamentGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tournamentGameRepository->add($tournamentGame, true);

            return $this->redirectToRoute('app_tournament_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tournament_game/edit.html.twig', [
            'tournament_game' => $tournamentGame,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tournament_game_delete", methods={"POST"})
     */
    public function delete(Request $request, TournamentGame $tournamentGame, TournamentGameRepository $tournamentGameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tournamentGame->getId(), $request->request->get('_token'))) {
            $tournamentGameRepository->remove($tournamentGame, true);
        }

        return $this->redirectToRoute('app_tournament_game_index', [], Response::HTTP_SEE_OTHER);
    }
}
