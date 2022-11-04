<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Team;
use App\Entity\Region;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use App\Repository\RegionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/game")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/", name="app_game_index", methods={"GET"})
     */
    public function index(GameRepository $gameRepository, TeamRepository $teamRepository, RegionRepository $regionRepository): Response
    {
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('game/index.html.twig', [
            'games' => $gameRepository->findAll(),
            'teams' => $teamRepository->findAll(),
            'regions' => $regions,
            'user' => $user,
        ]);
    }
        /**
     * @Route("/game_of_player", name="app_game_of_player", methods={"GET"})
     */
    public function game_of_player(GameRepository $gameRepository, TeamRepository $teamRepository, RegionRepository $regionRepository): Response
    {
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('game/game_of_player.html.twig', [
            'games' => $gameRepository->findAll(),
            'teams' => $teamRepository->findAll(),
            'regions' => $regions,
            'user' => $user,
        ]);
    }
        /**
     * @Route("/game_by_region/{id}", name="app_game_by_region", methods={"GET"})
     */
    public function game_by_region(Region $region, GameRepository $gameRepository, TeamRepository $teamRepository, RegionRepository $regionRepository): Response
    {
        $user = $this->getUser();
        $regions = $regionRepository->findAll();
        return $this->render('game/searched_game.html.twig', [
            'games' => $gameRepository->findBy(['region'=>$region]),
            'region_selected' => $region,
            'regions' => $regions,
            'teams' => $teamRepository->findAll(),
            'user' => $user,
            //'region_selected' => $regionRepository->findAll(),
            //'regions' => $regions,
        ]);
    }

    /**
     * @Route("/new", name="app_game_new", methods={"GET", "POST"})
     */
    public function new(Request $request, GameRepository $gameRepository, TeamRepository $teamRepository): Response
    {   
        $user = $this->getUser();
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        //$repository = $entityManager->getRepository('AdminBundle:MyTable');

        $teamArray = [];
        $team = [];
        

        if ($form->isSubmitted() && $form->isValid()) {
            $date=new \Datetime('now');
            $game->setCreationDate($date);
            $game->setAuthor($user);
            $game->setGameStatut('cherche joueurs');
            
            
            if($game->isTournamentGame() == false){
                $game->setNbOfTeam(2);
            }elseif($game->isTournamentGame() == true && $game->getFormat() == 1){
                $game->setNbOfTeam($game->getNbTotalPlayer());
            }elseif($game->isTournamentGame() == true && $game->getFormat() == 2){
                $game->setNbOfTeam(($game->getNbTotalPlayer())/2);
            }elseif($game->isTournamentGame() == true && $game->getFormat() == 3){
                $game->setNbOfTeam(($game->getNbTotalPlayer())/3);
            }
           // $results = $repository->findBy($game,array('id'=>'DESC'),1,0);
          //  $nbTeam = $results->getNbOfTeam();

            $gameRepository->add($game, true);
           // $lastGame = $gameRepository->find($id);
           $lastGame= $gameRepository->findBy(['author'=>$user],array('id'=>'DESC'),1,0);
           $result = $lastGame[0];

            for($i=0; $i<$game->getNbOfTeam(); $i++){
               $team = new Team();
               $team->setTeamLinkForGame($result);
               $teamRepository->add($team, true);
           }
  



            
            
            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('game/new.html.twig', [
            'game' => $game,
            'team' => $team,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_game_show", methods={"GET"})
     */
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }
    /**
     * @Route("/game_single/{id}", name="app_game_single", methods={"GET"})
     */
    public function game_single(Game $game, TeamRepository $teamRepository): Response
    {
        $user = $this->getUser();
        $id = $game->getId();
        $teams = $teamRepository->findBy(['teamLinkForGame'=>$id]);
        return $this->render('game/game_single.html.twig', [
            'teams'=>$teams,
            'game' => $game,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_game_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Game $game, GameRepository $gameRepository): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gameRepository->add($game, true);

            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('game/edit.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_game_delete", methods={"POST"})
     */
    public function delete(Request $request, Game $game, GameRepository $gameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $gameRepository->remove($game, true);
        }

        return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
    }
}
