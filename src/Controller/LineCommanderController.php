<?php

namespace App\Controller;

use App\Entity\LineArmy;
use App\Entity\LineCommander;
use App\Form\DeleteCommander;
use App\Form\LineCommanderType;
use App\Repository\ArmyRepository;
use App\Repository\RegionRepository;
use App\Repository\LineArmyRepository;
use App\Repository\NotificationRepository;
use App\Repository\LineCommanderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/line/commander")
 */
class LineCommanderController extends AbstractController
{
    /**
     * @Route("/", name="app_line_commander_index", methods={"GET"})
     */
    public function index(LineCommanderRepository $lineCommanderRepository): Response
    {
        return $this->render('line_commander/index.html.twig', [
            'line_commanders' => $lineCommanderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_line_commander_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LineCommanderRepository $lineCommanderRepository): Response
    {
        $lineCommander = new LineCommander();
        $form = $this->createForm(LineCommanderType::class, $lineCommander);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineCommanderRepository->add($lineCommander, true);

            return $this->redirectToRoute('app_line_commander_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_commander/new.html.twig', [
            'line_commander' => $lineCommander,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_line_commander_show", methods={"GET"})
     */
    public function show(LineCommander $lineCommander): Response
    {
        return $this->render('line_commander/show.html.twig', [
            'line_commander' => $lineCommander,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_line_commander_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LineCommander $lineCommander, LineCommanderRepository $lineCommanderRepository): Response
    {
        $form = $this->createForm(LineCommanderType::class, $lineCommander);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineCommanderRepository->add($lineCommander, true);

            return $this->redirectToRoute('app_line_commander_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_commander/edit.html.twig', [
            'line_commander' => $lineCommander,
            'form' => $form,
        ]);
    }
        /**
     * @Route("/{id}/delete", name="app_line_commander_delete2", methods={"GET", "POST"})
     */
    public function delete2(Request $request, LineCommander $lineCommander, LineCommanderRepository $lineCommanderRepository, NotificationRepository $notificationRepository, RegionRepository $regionRepository, LineArmyRepository $lineArmyRepository, ArmyRepository $armyRepository): Response
    {   
        $linkLineArmy = $lineCommander->getLinkLineArmy();
        $CU = $linkLineArmy->getCombatUnit();
        $army = $linkLineArmy->getArmy();
        $qty = 0;   
        $lineArmy = new LineArmy();
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(DeleteCommander::class, $lineCommander);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineCommanderRepository->remove($lineCommander, true);
            $lineArmy->setArmy($army);
            $lineArmy->setCombatUnit($CU);
            $lineArmy->setQuantity($qty+1);
            $lineArmyRepository->add($lineArmy, true);

            return $this->redirectToRoute('app_army_edit', ['id' => $army->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_commander/edit.html.twig', [
            'line_commander' => $lineCommander,
            'form' => $form,
            'notifmenu'=>$notifmenu,
            'regions'=>$regions,
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{id}", name="app_line_commander_delete", methods={"POST"})
     */
    public function delete(Request $request, LineCommander $lineCommander, LineCommanderRepository $lineCommanderRepository): Response
    {

        if ($this->isCsrfTokenValid('delete'.$lineCommander->getId(), $request->request->get('_token'))) {
            $lineCommanderRepository->remove($lineCommander, true);
        }

        return $this->redirectToRoute('app_line_commander_index', [], Response::HTTP_SEE_OTHER);

    }
}
