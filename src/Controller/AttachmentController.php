<?php

namespace App\Controller;

use App\Entity\Attachment;
use App\Form\AttachmentType;
use App\Service\FileUploader;
use App\Repository\RegionRepository;
use App\Repository\AttachmentRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/attachment")
 */
class AttachmentController extends AbstractController
{
    /**
     * @Route("/", name="app_attachment_index", methods={"GET"})
     */
    public function index(AttachmentRepository $attachmentRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('attachment/index.html.twig', [
            'attachments' => $attachmentRepository->findAll(),
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/new", name="app_attachment_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AttachmentRepository $attachmentRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, FileUploader $fileUploader): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $attachment = new Attachment();
        $form = $this->createForm(AttachmentType::class, $attachment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->get('card')->getData();
            if($card){
                $fileName = $fileUploader->upload($card);
                $attachment->setCard($fileName);
            }
            $cardVerso = $form->get('cardVerso')->getData();
            if($cardVerso){
                $fileName = $fileUploader->upload($cardVerso);
                $attachment->setCardVerso($fileName);
            }
            $attachmentRepository->add($attachment, true);

            return $this->redirectToRoute('app_attachment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attachment/new.html.twig', [
            'attachment' => $attachment,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_attachment_show", methods={"GET"})
     */
    public function show(Attachment $attachment, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('attachment/show.html.twig', [
            'attachment' => $attachment,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_attachment_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Attachment $attachment, AttachmentRepository $attachmentRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, FileUploader $fileUploader): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(AttachmentType::class, $attachment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->get('card')->getData();
            if($card){
                $fileName = $fileUploader->upload($card);
                $attachment->setCard($fileName);
            }
            $cardVerso = $form->get('cardVerso')->getData();
            if($cardVerso){
                $fileName = $fileUploader->upload($cardVerso);
                $attachment->setCardVerso($fileName);
            }
            $attachmentRepository->add($attachment, true);

            return $this->redirectToRoute('app_attachment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attachment/edit.html.twig', [
            'attachment' => $attachment,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_attachment_delete", methods={"POST"})
     */
    public function delete(Request $request, Attachment $attachment, AttachmentRepository $attachmentRepository): Response
    {
        
        if ($this->isCsrfTokenValid('delete'.$attachment->getId(), $request->request->get('_token'))) {
            $attachmentRepository->remove($attachment, true);
        }

        return $this->redirectToRoute('app_attachment_index', [], Response::HTTP_SEE_OTHER);
    }
}
