<?php

namespace App\Controller;

use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\RegionRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/region")
 */
class RegionController extends AbstractController
{
    /**
     * @Route("/", name="app_region_index", methods={"GET"})
     */
    public function index(RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $regions = $regionRepository->findAll();
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);

        return $this->render('region/index.html.twig', [
            'regions' => $regionRepository->findAll(),
            'regions' => $regions,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/new", name="app_region_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $region = new Region();
        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $regionRepository->add($region, true);

            return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('region/new.html.twig', [
            'region' => $region,
            'form' => $form,
            'regions' => $regions,
            'notifmenu'=>$notifmenu,
            
        ]);
    }

    /**
     * @Route("/{id}", name="app_region_show", methods={"GET"})
     */
    public function show(Region $region, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        return $this->render('region/show.html.twig', [
            'region' => $region,
            'regions' => $regions,
            'notifmenu'=>$notifmenu,
            
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_region_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Region $region, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $regionRepository->add($region, true);

            return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('region/edit.html.twig', [
            'region' => $region,
            'form' => $form,
            'regions' => $regions,
            'notifmenu'=>$notifmenu,
            
        ]);
    }

    /**
     * @Route("/{id}", name="app_region_delete", methods={"POST"})
     */
    public function delete(Request $request, Region $region, RegionRepository $regionRepository): Response
    {
        
        if ($this->isCsrfTokenValid('delete'.$region->getId(), $request->request->get('_token'))) {
            $regionRepository->remove($region, true);
        }

        return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
    }
}
