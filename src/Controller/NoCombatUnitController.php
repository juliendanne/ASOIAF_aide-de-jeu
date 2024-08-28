<?php

namespace App\Controller;

use App\Entity\NoCombatUnit;
use App\Service\FileUploader;
use App\Form\NoCombatUnitType;
use App\Repository\RegionRepository;
use App\Repository\NoCombatUnitRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/no/combat/unit")
 */
class NoCombatUnitController extends AbstractController
{
    /**
     * @Route("/", name="app_no_combat_unit_index", methods={"GET"})
     */
    public function index(NoCombatUnitRepository $noCombatUnitRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('no_combat_unit/index.html.twig', [
            'no_combat_units' => $noCombatUnitRepository->findAll(),
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/new", name="app_no_combat_unit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NoCombatUnitRepository $noCombatUnitRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, FileUploader $fileUploader): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $noCombatUnit = new NoCombatUnit();
        $form = $this->createForm(NoCombatUnitType::class, $noCombatUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->get('card')->getData();
            if($card){
                $fileName = $fileUploader->upload($card);
                $noCombatUnit->setCard($fileName);
            }
            $cardVerso = $form->get('cardVerso')->getData();
            if($cardVerso){
                $fileName = $fileUploader->upload($cardVerso);
                $noCombatUnit->setCardVerso($fileName);
            }
            $noCombatUnitRepository->add($noCombatUnit, true);

            return $this->redirectToRoute('app_no_combat_unit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('no_combat_unit/new.html.twig', [
            'no_combat_unit' => $noCombatUnit,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_no_combat_unit_show", methods={"GET"})
     */
    public function show(NoCombatUnit $noCombatUnit, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('no_combat_unit/show.html.twig', [
            'no_combat_unit' => $noCombatUnit,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_no_combat_unit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NoCombatUnit $noCombatUnit, NoCombatUnitRepository $noCombatUnitRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, FileUploader $fileUploader): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(NoCombatUnitType::class, $noCombatUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->get('card')->getData();
            if($card){
                $fileName = $fileUploader->upload($card);
                $noCombatUnit->setCard($fileName);
            }
            $cardVerso = $form->get('cardVerso')->getData();
            if($cardVerso){
                $fileName = $fileUploader->upload($cardVerso);
                $noCombatUnit->setCardVerso($fileName);
            }
            $noCombatUnitRepository->add($noCombatUnit, true);

            return $this->redirectToRoute('app_no_combat_unit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('no_combat_unit/edit.html.twig', [
            'no_combat_unit' => $noCombatUnit,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_no_combat_unit_delete", methods={"POST"})
     */
    public function delete(Request $request, NoCombatUnit $noCombatUnit, NoCombatUnitRepository $noCombatUnitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noCombatUnit->getId(), $request->request->get('_token'))) {
            $noCombatUnitRepository->remove($noCombatUnit, true);
        }

        return $this->redirectToRoute('app_no_combat_unit_index', [], Response::HTTP_SEE_OTHER);
    }
}
