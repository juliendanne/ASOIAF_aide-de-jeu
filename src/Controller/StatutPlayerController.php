<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\StatutPlayer;
use App\Form\StatutPlayerType;
use App\Form\ValidatePlayerType;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use App\Repository\RegionRepository;
use App\Repository\NotificationRepository;
use App\Repository\StatutPlayerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/statut/player")
 */
class StatutPlayerController extends AbstractController
{
    /**
     * @Route("/", name="app_statut_player_index", methods={"GET"})
     */
    public function index(StatutPlayerRepository $statutPlayerRepository): Response
    {
        return $this->render('statut_player/index.html.twig', [
            'statut_players' => $statutPlayerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_statut_player_new", methods={"GET", "POST"})
     */
    public function new(Request $request, StatutPlayerRepository $statutPlayerRepository): Response
    {
        $statutPlayer = new StatutPlayer();
        $form = $this->createForm(StatutPlayerType::class, $statutPlayer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statutPlayerRepository->add($statutPlayer, true);

            return $this->redirectToRoute('app_statut_player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('statut_player/new.html.twig', [
            'statut_player' => $statutPlayer,
            'form' => $form,
        ]);
    }
        /**
     * @Route("/validate_player/{id}", name="app_validate_player", methods={"GET", "POST"})
     */
    // renvoie à un lien dans le template index parties organisateur
    public function validatePlayer(Request $request, StatutPlayer $statutPlayer, StatutPlayerRepository $statutPlayerRepository, GameRepository $gameRepository, UserRepository $userRepository, TeamRepository $teamRepository, NotificationRepository $notificationRepository, RegionRepository $regionRepository): Response
    {   
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        // on créer une nouvelle notification pour avertir de la confirmation ou du refus à l'inscription d'une partie
        $notification = new Notification;
        $form = $this->createForm(ValidatePlayerType::class, $statutPlayer);
        $form->handleRequest($request);
        // on récupère l'id du joueur concerné par le statut dans la partie
        $addresseeId = $statutPlayer->getPlayers();
        // on récupère l'utilisateur correspondant à l'id plus haut
        $addressee = $userRepository->findOneBy(['id'=>$addresseeId]);
        // on récupère l'id de l'équipe du joueur concerné par le statut du joueur dans la partie
        $teamId = $statutPlayer->getTeams();
        // on récupère l'équipe correspondant à l'id plus haut
        $team = $teamRepository->findOneBy(['id'=>$teamId]);
        // on récupère l'id de la partie liée à l'équipe plus haut
        $game2id = $team->getTeamLinkForGame();
        // on met toutes les parties dans une variable
        $games = $gameRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            // on boucle sur la variable contenant toutes les équipes
            foreach($games as $game1){
                // on récupère les id des parties
                $game1id = $game1->getId();
                // on compare l'id des parties avec l'id de la partie liée au statutPlayer qui doit être validé, si c'est identique, on applique le traitement suivant
                if($game1id == $game2id->getId()){
                    $notification->setObject('Votre demande a été '.$statutPlayer->getName());
                    $notification->setNotifAuthor($user);
                    $notification->setAddressee($addressee);
                    $notification->setCreationDate(new \DateTime('now'));
                    // si le joueur est refusé
                    if($statutPlayer->getName()=='refusé'){
                        // on retire le joueur concerné des tables team_user et game_user à l'aide des méthodes removePlayersInTeam et removePlayersjoined
                        $team->removePlayersInTeam($addressee);
                        $game1->removePlayersjoined($addressee);   
                    }
                    $notification->setGame($game1);
                    $notification->setContent($user->getLogin().' a '.$statutPlayer->getName().' votre demande de partie '.$game1->getName().' du '.$game1->getDate()->format('d-m-Y'));
                    $notification->setStatut('non lu');
                    $notificationRepository->add($notification, true);
                    $statutPlayerRepository->add($statutPlayer, true);
                }
            }
            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
            
        }

        return $this->renderForm('statut_player/validate_player.html.twig', [
            'statut_player' => $statutPlayer,
            'game2id'=>$game2id,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
             'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_statut_player_show", methods={"GET"})
     */
    public function show(StatutPlayer $statutPlayer): Response
    {
        return $this->render('statut_player/show.html.twig', [
            'statut_player' => $statutPlayer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_statut_player_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, StatutPlayer $statutPlayer, StatutPlayerRepository $statutPlayerRepository): Response
    {
        $form = $this->createForm(StatutPlayerType::class, $statutPlayer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statutPlayerRepository->add($statutPlayer, true);

            return $this->redirectToRoute('app_statut_player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('statut_player/edit.html.twig', [
            'statut_player' => $statutPlayer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_statut_player_delete", methods={"POST"})
     */
    public function delete(Request $request, StatutPlayer $statutPlayer, StatutPlayerRepository $statutPlayerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statutPlayer->getId(), $request->request->get('_token'))) {
            $statutPlayerRepository->remove($statutPlayer, true);
        }

        return $this->redirectToRoute('app_statut_player_index', [], Response::HTTP_SEE_OTHER);
    }
}
