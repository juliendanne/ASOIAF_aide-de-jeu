<?php

namespace App\Controller;

use App\Entity\TypeOfUnit;
use App\Form\TypeOfUnitType;
use App\Repository\RegionRepository;
use App\Repository\TypeOfUnitRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/type/of/unit")
 */
class TypeOfUnitController extends AbstractController
{
    /**
     * @Route("/", name="app_type_of_unit_index", methods={"GET"})
     */
    public function index(TypeOfUnitRepository $typeOfUnitRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('type_of_unit/index.html.twig', [
            'type_of_units' => $typeOfUnitRepository->findAll(),
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/new", name="app_type_of_unit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TypeOfUnitRepository $typeOfUnitRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $typeOfUnit = new TypeOfUnit();
        $form = $this->createForm(TypeOfUnitType::class, $typeOfUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeOfUnitRepository->add($typeOfUnit, true);

            return $this->redirectToRoute('app_type_of_unit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_of_unit/new.html.twig', [
            'type_of_unit' => $typeOfUnit,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_of_unit_show", methods={"GET"})
     */
    public function show(TypeOfUnit $typeOfUnit, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('type_of_unit/show.html.twig', [
            'type_of_unit' => $typeOfUnit,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_type_of_unit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeOfUnit $typeOfUnit, TypeOfUnitRepository $typeOfUnitRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(TypeOfUnitType::class, $typeOfUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeOfUnitRepository->add($typeOfUnit, true);

            return $this->redirectToRoute('app_type_of_unit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_of_unit/edit.html.twig', [
            'type_of_unit' => $typeOfUnit,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_of_unit_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeOfUnit $typeOfUnit, TypeOfUnitRepository $typeOfUnitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeOfUnit->getId(), $request->request->get('_token'))) {
            $typeOfUnitRepository->remove($typeOfUnit, true);
        }

        return $this->redirectToRoute('app_type_of_unit_index', [], Response::HTTP_SEE_OTHER);
    }
}
