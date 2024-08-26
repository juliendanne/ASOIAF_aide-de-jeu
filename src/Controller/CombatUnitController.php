<?php

namespace App\Controller;

use App\Entity\CombatUnit;
use App\Form\CombatUnitType;
use App\Service\FileUploader;
use App\Repository\RegionRepository;
use App\Repository\CombatUnitRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/combat/unit")
 */
class CombatUnitController extends AbstractController
{
    /**
     * @Route("/", name="app_combat_unit_index", methods={"GET"})
     */
    public function index(CombatUnitRepository $combatUnitRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('combat_unit/index.html.twig', [
            'combat_units' => $combatUnitRepository->findAll(),
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/new", name="app_combat_unit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CombatUnitRepository $combatUnitRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, FileUploader $fileUploader): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $combatUnit = new CombatUnit();
        $form = $this->createForm(CombatUnitType::class, $combatUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->get('card')->getData();
            if($card){
                $fileName = $fileUploader->upload($card);
                $combatUnit->setCard($fileName);
            }
            $cardVerso = $form->get('cardVerso')->getData();
            if($cardVerso){
                $fileName = $fileUploader->upload($cardVerso);
                $combatUnit->setCardVerso($fileName);
            }
            $combatUnitRepository->add($combatUnit, true);

            return $this->redirectToRoute('app_combat_unit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('combat_unit/new.html.twig', [
            'combat_unit' => $combatUnit,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_combat_unit_show", methods={"GET"})
     */
    public function show(CombatUnit $combatUnit, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('combat_unit/show.html.twig', [
            'combat_unit' => $combatUnit,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_combat_unit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CombatUnit $combatUnit, CombatUnitRepository $combatUnitRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, FileUploader $fileUploader): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(CombatUnitType::class, $combatUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->get('card')->getData();
            if($card){
                $fileName = $fileUploader->upload($card);
                $combatUnit->setCard($fileName);
            }
            $cardVerso = $form->get('cardVerso')->getData();
            if($cardVerso){
                $fileName = $fileUploader->upload($cardVerso);
                $combatUnit->setCardVerso($fileName);
            }
            $combatUnitRepository->add($combatUnit, true);

            return $this->redirectToRoute('app_combat_unit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('combat_unit/edit.html.twig', [
            'combat_unit' => $combatUnit,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_combat_unit_delete", methods={"POST"})
     */
    public function delete(Request $request, CombatUnit $combatUnit, CombatUnitRepository $combatUnitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$combatUnit->getId(), $request->request->get('_token'))) {
            $combatUnitRepository->remove($combatUnit, true);
        }

        return $this->redirectToRoute('app_combat_unit_index', [], Response::HTTP_SEE_OTHER);
    }
}
