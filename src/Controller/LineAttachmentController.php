<?php

namespace App\Controller;

use App\Entity\LineArmy;
use App\Entity\LineAttachment;
use App\Form\DeleteAttachment;
use App\Form\LineAttachmentType;
use App\Repository\ArmyRepository;
use App\Repository\RegionRepository;
use App\Repository\LineArmyRepository;
use App\Repository\NotificationRepository;
use App\Repository\LineAttachmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/line/attachment")
 */
class LineAttachmentController extends AbstractController
{
    /**
     * @Route("/", name="app_line_attachment_index", methods={"GET"})
     */
    public function index(LineAttachmentRepository $lineAttachmentRepository): Response
    {
        return $this->render('line_attachment/index.html.twig', [
            'line_attachments' => $lineAttachmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_line_attachment_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LineAttachmentRepository $lineAttachmentRepository, LineArmyRepository $lineArmyRepository): Response
    {
        $lineAttachment = new LineAttachment();
        $form = $this->createForm(LineAttachmentType::class, $lineAttachment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $lineAttachmentRepository->add($lineAttachment, true);

            return $this->redirectToRoute('app_army_edit', ['id' => $linkarmyid], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_attachment/new.html.twig', [
            'line_attachment' => $lineAttachment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_line_attachment_show", methods={"GET"})
     */
    public function show(LineAttachment $lineAttachment): Response
    {
        return $this->render('line_attachment/show.html.twig', [
            'line_attachment' => $lineAttachment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_line_attachment_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LineAttachment $lineAttachment, LineAttachmentRepository $lineAttachmentRepository): Response
    {
        $form = $this->createForm(LineAttachmentType::class, $lineAttachment);
        $form->handleRequest($request);
        $linklinearmy = $lineAttachment->getLineArmy();
        $linkarmy = $linklinearmy->getArmy();
        $linkarmyid = $linkarmy->getId();
        if ($form->isSubmitted() && $form->isValid()) {
            $lineAttachmentRepository->add($lineAttachment, true);

            return $this->redirectToRoute('app_line_attachment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_attachment/edit.html.twig', [
            'line_attachment' => $lineAttachment,
            'form' => $form,
        ]);
    }
            /**
     * @Route("/{id}/delete", name="app_line_attachment_delete2", methods={"GET", "POST"})
     */
    public function attachmentdelete2(Request $request, LineAttachment $lineAttachment, LineAttachmentRepository $lineAttachmentRepository, NotificationRepository $notificationRepository, RegionRepository $regionRepository, LineArmyRepository $lineArmyRepository, ArmyRepository $armyRepository): Response
    {   
        $linkLineArmy = $lineAttachment->getLineArmy();
        $CU = $linkLineArmy->getCombatUnit();
        $army = $linkLineArmy->getArmy();
        $qty = 0;   
        $lineArmy = new LineArmy();
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(DeleteAttachment::class, $lineAttachment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineAttachmentRepository->remove($lineAttachment, true);


            return $this->redirectToRoute('app_army_edit', ['id' => $army->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_attachment/edit.html.twig', [
            'line_attachment' => $lineAttachment,
            'form' => $form,
            'notifmenu'=>$notifmenu,
            'regions'=>$regions,
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{id}", name="app_line_attachment_delete", methods={"POST"})
     */
    public function delete(Request $request, LineAttachment $lineAttachment, LineAttachmentRepository $lineAttachmentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineAttachment->getId(), $request->request->get('_token'))) {
            $lineAttachmentRepository->remove($lineAttachment, true);
        }

        return $this->redirectToRoute('app_line_attachment_index', [], Response::HTTP_SEE_OTHER);
    }
}
