<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Form\JoinTeamType;
use App\Form\QuitTeamType;
use App\Entity\Notification;
use App\Entity\StatutPlayer;
use App\Form\ValidatePlayerType;
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
    public function edit(Request $request, Team $team, TeamRepository $teamRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->add($team, true);

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
            'regions' => $regions,
            'notifmenu'=>$notifmenu,
            'user' => $user,
        ]);
    }
 
        /**
     * @Route("/join_team/{id}", name="app_join_team", methods={"GET", "POST"})
     */
    // accessible depuis le template game_single qui affiche le détail d'une partie, il permet de rejoindre une équipe associée à une partie, il envoie une notification à l'auteur de la partie car ce dernier doit valider ou refuser l'inscription
    public function join_team(Request $request, Team $team, TeamRepository $teamRepository, StatutPlayerRepository $statutPlayerRepository, GameRepository $gameRepository, NotificationRepository $notificationRepository, RegionRepository $regionRepository): Response
    {   
        // on récupère l'id de la partie liée à l'équipe
        $gameId = $team->getTeamLinkForGame();
        // on récupère la partie liée à l'équipe avec l'id plus haut
        $game = $gameRepository->findOneBy(['id'=>$gameId]);
        // on récupère le nom et la date de la partie pour l'ajouter dans la propriété content de la notification qui sera créer à l'adresse de l'auteur de la partie
        $gameName = $game->getName();
        $gameDate = ($game->getDate())->format('d-m-Y');


        $user = $this->getUser();
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        // si $user!=null, donc si l'utilisateur est connecté, on doit faire cela pour éviter un message d'erreur sur la page si l'on est déconnecté, alors on déclenche le traitement suivant
        if($user!=null){
        $userId = $user->getId();}
        // on créer un objet de la classe StatutPlayer
        $statutPlayer = new StatutPlayer;
        // le nom de ce statut sera par défault
        $statutPlayer->setName('en cours de validation');
        // on créer une notification adresser à l'auteur
        $notification = new Notification;
        $form = $this->createForm(JoinTeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on ajoute l'utilisateur connecté comme participant à la partie ainsi qu'à une équipe
            $game->addPlayersjoined($user);
            $team->addPlayersInTeam($user);
            // on ajoute le statut du joueur à la propriété statutPlayer de l'équipe
            $team->addStatutPlayer($statutPlayer);
            // on renseigne les propriétés suivantes
            $notification->setObject('Demande d\'ajout à une partie');
            $notification->setNotifAuthor($user);
            $notification->setAddressee($game->getAuthor());
            $notification->setGame($game);
            $notification->setContent($user->getLogin().' souhaite rejoindre votre partie '.$gameName.' du '.$gameDate);
            $notification->setStatut('non lu');
            $notification->setCreationDate(new \DateTime('now'));
            // on ajoute à l'objet statutPlayer la propriété players, ici l'utilisateur connecté
            $statutPlayer->setPlayers($user);
            // on modifie la bdd
            $teamRepository->add($team, true);
            $gameRepository->add($game, true);
            $statutPlayerRepository->add($statutPlayer, true);
            $notificationRepository->add($notification, true);
            return $this->redirectToRoute('app_game_of_player', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/join_team.html.twig', [
            'team' => $team,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }
            /**
     * @Route("/quit_team/{id}", name="app_quit_team", methods={"GET", "POST"})
     */
    // accessible depuis le template game_of_player qui affiche les parties auxquelles est inscrit en tant que joueur un utilisateur
    public function quit_team(Request $request, Team $team, TeamRepository $teamRepository, StatutPlayerRepository $statutPlayerRepository, GameRepository $gameRepository, NotificationRepository $notificationRepository, RegionRepository $regionRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        // on récupère l'id de la partie par la propriété de l'équipe teamLinkForGame
        $gameId = $team->getTeamLinkForGame();
        // on récupère la partie
        $game = $gameRepository->findOneBy(['id'=>$gameId]);
        $user = $this->getUser();
        // on récupère l'id de l'équipe qu'on veut quitter
        $teamId = $team->getId();
        // on récupère l'id de l'utilisateur
        $userId = $user->getId();
        // on sélectionne un objet statutPlayer avec l'id de l'utilisateur et l'id de l'équipe
        $statutPlayer = $statutPlayerRepository->findOneBy(['teams'=>$teamId, 'players'=>$userId]);
        $form = $this->createForm(QuitTeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on retire l'utilisateur de l'équipe concerné et de la partie
            $team->removePlayersInTeam($user);
            $game->removePlayersjoined($user);
            $gameRepository->add($game, true);
            $teamRepository->add($team, true);
            // on supprime le statutPlayer lié au joueur et à l'équipe
            $statutPlayerRepository->remove($statutPlayer, true);
            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/quit_team.html.twig', [
            'team' => $team,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
             'notifmenu'=>$notifmenu,
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
