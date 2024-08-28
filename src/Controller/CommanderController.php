<?php

namespace App\Controller;

use App\Entity\Commander;
use App\Form\CommanderType;
use App\Service\FileUploader;
use App\Repository\RegionRepository;
use App\Repository\CommanderRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/commander")
 */
class CommanderController extends AbstractController
{
    /**
     * @Route("/", name="app_commander_index", methods={"GET"})
     */
    public function index(CommanderRepository $commanderRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('commander/index.html.twig', [
            'commanders' => $commanderRepository->findAll(),
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/new", name="app_commander_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CommanderRepository $commanderRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, FileUploader $fileUploader): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $commander = new Commander();
        $form = $this->createForm(CommanderType::class, $commander);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commander->setIsACharacter(true);
            $card = $form->get('card')->getData();
            if($card){
                $fileName = $fileUploader->upload($card);
                $commander->setCard($fileName);
            }
            $cardVerso = $form->get('cardVerso')->getData();
            if($cardVerso){
                $fileName = $fileUploader->upload($cardVerso);
                $commander->setCardVerso($fileName);
            }
            $commanderRepository->add($commander, true);

            return $this->redirectToRoute('app_commander_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commander/new.html.twig', [
            'commander' => $commander,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_commander_show", methods={"GET"})
     */
    public function show(Commander $commander, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('commander/show.html.twig', [
            'commander' => $commander,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_commander_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commander $commander, CommanderRepository $commanderRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, FileUploader $fileUploader): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(CommanderType::class, $commander);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->get('card')->getData();
            if($card){
                $fileName = $fileUploader->upload($card);
                $commander->setCard($fileName);
            }
            $cardVerso = $form->get('cardVerso')->getData();
            if($cardVerso){
                $fileName = $fileUploader->upload($cardVerso);
                $commander->setCardVerso($fileName);
            }
            $commanderRepository->add($commander, true);

            return $this->redirectToRoute('app_commander_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commander/edit.html.twig', [
            'commander' => $commander,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_commander_delete", methods={"POST"})
     */
    public function delete(Request $request, Commander $commander, CommanderRepository $commanderRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commander->getId(), $request->request->get('_token'))) {
            $commanderRepository->remove($commander, true);
        }

        return $this->redirectToRoute('app_commander_index', [], Response::HTTP_SEE_OTHER);
    }
}
