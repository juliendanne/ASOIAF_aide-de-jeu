<?php

namespace App\Controller;

use App\Entity\LineNCU;
use App\Form\LineNCUType;
use App\Form\DeleteLineNCU;
use App\Repository\RegionRepository;
use App\Repository\LineNCURepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/line/n/c/u")
 */
class LineNCUController extends AbstractController
{
    /**
     * @Route("/", name="app_line_n_c_u_index", methods={"GET"})
     */
    public function index(LineNCURepository $lineNCURepository): Response
    {
        return $this->render('line_ncu/index.html.twig', [
            'line_n_c_us' => $lineNCURepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_line_n_c_u_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LineNCURepository $lineNCURepository): Response
    {
        $lineNCU = new LineNCU();
        $form = $this->createForm(LineNCUType::class, $lineNCU);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineNCURepository->add($lineNCU, true);

            return $this->redirectToRoute('app_line_n_c_u_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_ncu/new.html.twig', [
            'line_n_c_u' => $lineNCU,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_line_n_c_u_show", methods={"GET"})
     */
    public function show(LineNCU $lineNCU): Response
    {
        return $this->render('line_ncu/show.html.twig', [
            'line_n_c_u' => $lineNCU,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_line_n_c_u_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LineNCU $lineNCU, LineNCURepository $lineNCURepository): Response
    {
        $form = $this->createForm(LineNCUType::class, $lineNCU);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineNCURepository->add($lineNCU, true);

            return $this->redirectToRoute('app_line_n_c_u_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_ncu/edit.html.twig', [
            'line_n_c_u' => $lineNCU,
            'form' => $form,
        ]);
    }
        /**
     * @Route("/{id}/delete2", name="app_lineNCU_delete2", methods={"GET", "POST"})
     */
    public function NCUdelete2(Request $request, LineNCU $lineNCU, LineNCURepository $lineNCURepository, NotificationRepository $notificationRepository, RegionRepository $regionRepository): Response
    {
        $army = $lineNCU->getArmy();
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(DeleteLineNCU::class, $lineNCU);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineNCURepository->remove($lineNCU, true);

            return $this->redirectToRoute('app_army_edit', ['id' => $army->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_ncu/edit.html.twig', [
            'line_n_c_u' => $lineNCU,
            'form' => $form,
            'notifmenu'=>$notifmenu,
            'regions'=>$regions,
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{id}", name="app_line_n_c_u_delete", methods={"POST"})
     */
    public function delete(Request $request, LineNCU $lineNCU, LineNCURepository $lineNCURepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineNCU->getId(), $request->request->get('_token'))) {
            $lineNCURepository->remove($lineNCU, true);
        }

        return $this->redirectToRoute('app_line_n_c_u_index', [], Response::HTTP_SEE_OTHER);
    }
}
