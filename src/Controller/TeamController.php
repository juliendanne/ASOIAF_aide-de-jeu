<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Form\JoinTeamType;
use App\Form\QuitTeamType;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/team")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/", name="app_team_index", methods={"GET"})
     */
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_team_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TeamRepository $teamRepository): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->add($team, true);

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_team_show", methods={"GET"})
     */
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_team_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->add($team, true);

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }
        /**
     * @Route("/join_team/{id}", name="app_join_team", methods={"GET", "POST"})
     */
    public function join_team(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(JoinTeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team->addPlayersInTeam($user);
            $teamRepository->add($team, true);

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/join_team.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }
            /**
     * @Route("/quit_team/{id}", name="app_quit_team", methods={"GET", "POST"})
     */
    public function quit_team(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(QuitTeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team->removePlayersInTeam($user);
            $teamRepository->add($team, true);

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/quit_team.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_team_delete", methods={"POST"})
     */
    public function delete(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $teamRepository->remove($team, true);
        }

        return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
    }
}
