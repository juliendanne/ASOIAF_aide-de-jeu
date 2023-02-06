<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Team;
use App\Entity\Region;
use App\Form\GameType;
use App\Form\GameEditType;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use App\Repository\RegionRepository;
use App\Repository\NotificationRepository;
use App\Repository\StatutPlayerRepository;
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
    // ici, on renvoie à un template affichant les parties des utilisateurs en tant qu'organisateur ou administrateur car une fonction d'édition sera disponible
    public function index(GameRepository $gameRepository, TeamRepository $teamRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        // on définit la variable $notifmenu qui contient les notifications non lu d'un utilisateur pour afficher dans le menu un jeton indiquant le nombre de nouvelles notifications adressées à l'utilisateur
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        // on définit la variable $régions qui contient toutes les régions de la table région liée aux parties, cela sert à classer les parties disponibles depuis le menu
        $regions = $regionRepository->findAll();
        // on définit la variable $user car certains éléments du site ne sont disponibles que pour un utilisateur connecté, de plus il s'agit d'un filtre pour rendre disponible certaines informations seulement à l'utilisateur concerné
        $user = $this->getUser();
        // on retourne les variables dans le template
        return $this->render('game/index.html.twig', [
            // comme le template en question gère les parties disponibles on créer 2 variables games et teams à afficher dans le template
            'games' => $gameRepository->findAll(),
            'teams' => $teamRepository->findAll(),
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
            
        ]);
    }
        /**
     * @Route("/game_of_player", name="app_game_of_player", methods={"GET"})
     */
    // renvoie au template affichant les parties où est inscrit un utilisateur en tant que joueur, une fonctioon pour quitter la partie est disponible
    public function game_of_player(GameRepository $gameRepository, TeamRepository $teamRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, StatutPlayerRepository $statutPlayerRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $games = $gameRepository->findAll();
        $teams = $teamRepository->findAll();
        $statutsPlayer = $statutPlayerRepository->findAll();
        return $this->render('game/game_of_player.html.twig', [
            'games' => $games,
            'teams' => $teams,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
            'statutsPlayer'=>$statutsPlayer,
            
        ]);
    }
        /**
     * @Route("/game_by_region/{id}", name="app_game_by_region", methods={"GET"})
     */
    // sert à afficher les parties disponibles filtrées par région
    public function game_by_region(Region $region, GameRepository $gameRepository, TeamRepository $teamRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $user = $this->getUser();
        $regions = $regionRepository->findAll();
        return $this->render('game/searched_game.html.twig', [
            'games' => $gameRepository->findBy(['region'=>$region]),
            'region_selected' => $region,
            'regions' => $regions,
            'teams' => $teamRepository->findAll(),
            'user' => $user,
            'notifmenu'=>$notifmenu,
            
            //'region_selected' => $regionRepository->findAll(),
            //'regions' => $regions,
        ]);
    }

    /**
     * @Route("/search_result/{critere}", name="app_search_result", methods={"GET", "POST"})
     */
    // sert a afficher les résultats d'une recherche de partie via la barre de recherche
    public function game_search($critere, GameRepository $gameRepository, TeamRepository $teamRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {   
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]); 
        $user = $this->getUser();
        $regions = $regionRepository->findAll();
        // si la variable $critere existe
        if($critere){
            // on définit une variable $gameList qui récupère les parties incluant $critere
            $gameList = $gameRepository->search($critere);
            // si la variable $gameList n'est pas un tableau vide
            if($gameList != []){
            return $this->render('game/result.html.twig',[
                'games' => $gameList,
                'regions' => $regions,
                'teams' => $teamRepository->findAll(),
                'user' => $user,
                'notifmenu'=>$notifmenu,
                
            ]);
            // sinon on ajoute la variable message
            }else{
                return $this->render('game/result.html.twig',[
                    'games' => $gameList,
                    'regions' => $regions,
                    'teams' => $teamRepository->findAll(),
                    'user' => $user,
                    'notifmenu'=>$notifmenu,
                    
                'message'=>'pas de résultat pour la recherche '.$critere,
                ]);
    }}}

    /**
     * @Route("/new", name="app_game_new", methods={"GET", "POST"})
     */
    // renvoie au template de création d'une partie
    public function new(Request $request, GameRepository $gameRepository, TeamRepository $teamRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {   
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        // on définit une variable $game qui contient un nouvel objet de la classe Game
        $game = new Game();
        // on définit un variable $form qui renvoie à un formulaire, on précise lequel
        $form = $this->createForm(GameType::class, $game);
        // la méthode handleRequest permet d'envoyer les donner du formulaire
        $form->handleRequest($request);

        // comme on va renvoyer aussi des données relatives à des équipes qui seront créer en fonction des paramètres de la partie, on définit une variable $team qui est pour l'instant un tableau vide
        $team = []; 
        
        // si le formulaire est envoyé et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // ces propriétés de $game sont renseignées automatiquement
            $date=new \Datetime('now');
            $game->setCreationDate($date);
            $game->setAuthor($user);
            $game->setGameStatut('cherche joueurs');
            $game->setCreationDate(new \DateTime('now'));
            // si la propriété isTournamentGame est false
            if($game->isTournamentGame() == false){
                //  on renseigne les propriétés suivantes
                $game->setNbOfTeam(2);
                $game->setNbTotalPlayer(2);
            //sinon
            }elseif($game->isTournamentGame() == true && $game->getFormat() == 1){
                $game->setNbOfTeam($game->getNbTotalPlayer());
            }elseif($game->isTournamentGame() == true && $game->getFormat() == 2){
                $game->setNbOfTeam(($game->getNbTotalPlayer())/2);
            }elseif($game->isTournamentGame() == true && $game->getFormat() == 3){
                $game->setNbOfTeam(($game->getNbTotalPlayer())/3);
            }
 
            // on écrit l'objet dans la bdd
            $gameRepository->add($game, true);

           // on definit une variable lastGame qui récupère la dernière partie de l'auteur (que l'on vient de créer)
           $lastGame= $gameRepository->findBy(['author'=>$user],array('id'=>'DESC'),1,0);
           //on récupère l'id de cette partie
           $result = $lastGame[0];
            // on boucle un nb de fois égale au nb d'équipe de la partie nbOfTeam
            for($i=0; $i<$game->getNbOfTeam(); $i++){
               // on créer une équipe par boucle
               $team = new Team();
               // on donne à la propriété teamLinkForGame de ces équipes l'id de la partie
               $team->setTeamLinkForGame($result);
               // on écrit dans la bdd
               $teamRepository->add($team, true);
           }
  
            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('game/new.html.twig', [
            'game' => $game,
            'team' => $team,
            'form' => $form,
            'regions' => $regions,
            'notifmenu'=>$notifmenu,
            'user' => $user,
            
        ]);
    }

    /**
     * @Route("/{id}", name="app_game_show", methods={"GET"})
     */
    public function show(Game $game, RegionRepository $regionRepository, NotificationRepository $notificationRepository, TeamRepository $teamRepository): Response
    {
        $user = $this->getUser();
        $regions = $regionRepository->findAll();
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $id = $game->getId();
        $teams = $teamRepository->findBy(['teamLinkForGame'=>$id]);
        return $this->render('game/show.html.twig', [
            'game' => $game,
            'regions' => $regions,
            'notifmenu'=>$notifmenu,
            'user' => $user,
            'teams' => $teams,
        ]);
    }
    /**
     * @Route("/game_single/{id}", name="app_game_single", methods={"GET"})
     */
    // il renvoie au détail d'une partie, il affiche les liens qui permettent de rejoindre les équipes qui participent à la partie
    public function game_single(Game $game, TeamRepository $teamRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $regions = $regionRepository->findAll();
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $user = $this->getUser();
        // on définit la variable $id avec l'id de la partie
        $id = $game->getId();
        // on définit une variable $teams, on va chercher avec la méthode findBy les équipes liées à la partie possédant l'id récupérée plus haut
        $teams = $teamRepository->findBy(['teamLinkForGame'=>$id]);
        return $this->render('game/game_single.html.twig', [
            'teams'=>$teams,
            'game' => $game,
            'user' => $user,
            'regions' => $regions,
            'notifmenu'=>$notifmenu,
            
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_game_edit", methods={"GET", "POST"})
     */
    
    public function edit(Request $request, Game $game, GameRepository $gameRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $user = $this->getUser();
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $form = $this->createForm(GameEditType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gameRepository->add($game, true);
            $date=new \Datetime('now');
            $game->setModifDate($date);
            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('game/edit.html.twig', [
            'game' => $game,
            'form' => $form,
            'regions' => $regions,
            'notifmenu'=>$notifmenu,
            'user' => $user,
            
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
