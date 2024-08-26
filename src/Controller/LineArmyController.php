<?php

namespace App\Controller;

use App\Entity\LineArmy;
use App\Entity\Attachment;
use App\Form\LineArmyType;
use App\Form\LineArmy1Type;
use App\Form\DeleteLineArmy;
use App\Entity\LineCommander;
use App\Entity\LineAttachment;
use App\Form\LineArmyCommanderType;
use App\Repository\RegionRepository;
use App\Repository\LineArmyRepository;
use App\Repository\AttachmentRepository;
use App\Repository\NotificationRepository;
use App\Repository\LineCommanderRepository;
use App\Repository\LineAttachmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/line/army")
 */
class LineArmyController extends AbstractController
{
    /**
     * @Route("/", name="app_line_army_index", methods={"GET"})
     */
    public function index(LineArmyRepository $lineArmyRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response

    {
               $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
            $regions = $regionRepository->findAll();
            $user = $this->getUser();
        return $this->render('line_army/index.html.twig', [
            'line_armies' => $lineArmyRepository->findAll(),
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/new", name="app_line_army_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LineArmyRepository $lineArmyRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
         $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
            $regions = $regionRepository->findAll();
            $user = $this->getUser();
        $lineArmy = new LineArmy();
        $form = $this->createForm(LineArmyType::class, $lineArmy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineArmyRepository->add($lineArmy, true);

            return $this->redirectToRoute('app_line_army_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_army/new.html.twig', [
            'line_army' => $lineArmy,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}", name="app_line_army_show", methods={"GET"})
     */
    public function show(LineArmy $lineArmy, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response

    {         $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
            $regions = $regionRepository->findAll();
            $user = $this->getUser();
        return $this->render('line_army/show.html.twig', [
            'line_army' => $lineArmy,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_line_army_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LineArmy $lineArmy, LineArmyRepository $lineArmyRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, LineAttachmentRepository $lineAttachmentRepository, AttachmentRepository $attachmentRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(LineArmyType::class, $lineArmy);
        $form->handleRequest($request);

        $army = $lineArmy->getArmy();

        $lineAttachment = new LineAttachment();
        
        


        if ($form->isSubmitted() && $form->isValid()) {
            $lineArmyRepository->add($lineArmy, true);
            $lineAttachment->setLineArmy($lineArmy);
            $lineAttachment->setAuthor($user);
            $lineAttachment->setArmy($army);

            $attachments = $lineArmy->getAttachments();
            $lastAttachment = $attachments[count($attachments)-1];
            $lastAttachmentId = $lastAttachment->getId();

            $attachmentToAdd = $attachmentRepository->findOneBy(['id'=>$lastAttachmentId]);
            $lineAttachment->setAttachment($attachmentToAdd);

            $lineAttachmentRepository->add($lineAttachment, true);


           
            

             return $this->redirectToRoute('app_army_edit',  ['id' => $army->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_army/edit.html.twig', [
            'line_army' => $lineArmy,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
            'army'=>$army,
        ]);
    }
        /**
     * @Route("/{id}/delete2", name="app_line_army_delete2", methods={"GET", "POST"})
     */
    public function delete2(Request $request, LineArmy $lineArmy, LineArmyRepository $lineArmyRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, LineAttachmentRepository $lineAttachmentRepository, AttachmentRepository $attachmentRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(DeleteLineArmy::class, $lineArmy);
        $form->handleRequest($request);

        $army = $lineArmy->getArmy();

        $lineAttachment = new LineAttachment();
        
        


        if ($form->isSubmitted() && $form->isValid()) {
            $lineArmyRepository->remove($lineArmy, true);



           
            

             return $this->redirectToRoute('app_army_edit',  ['id' => $army->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_army/edit.html.twig', [
            'line_army' => $lineArmy,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }
        /**
     * @Route("/{id}/commander_edit", name="app_line_army_commander_edit", methods={"GET", "POST"})
     */
    public function commander_edit(Request $request, LineArmy $lineArmy, LineArmyRepository $lineArmyRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, LineAttachmentRepository $lineAttachmentRepository, AttachmentRepository $attachmentRepository, LineCommanderRepository $lineCommanderRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(LineArmyCommanderType::class, $lineArmy);
        $form->handleRequest($request);

        $army = $lineArmy->getArmy();
        $commander=$army->getCommander();
        $lineCommander = new LineCommander();
        
        


        if ($form->isSubmitted() && $form->isValid()) {
            $lineArmyRepository->add($lineArmy, true);
            $lineCommander->setLinkLineArmy($lineArmy);
            $lineCommander->setAuthor($user);
            $lineCommander->setArmy($army);

            //$commander = $lineArmy->getCommander();
/*             $lastAttachment = $attachments[count($attachments)-1];
            $lastAttachmentId = $lastAttachment->getId();

            $attachmentToAdd = $attachmentRepository->findOneBy(['id'=>$lastAttachmentId]); */
            $lineCommander->setCommander($commander);

            $lineCommanderRepository->add($lineCommander, true);


           
            

             return $this->redirectToRoute('app_army_edit',  ['id' => $army->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line_army/edit.html.twig', [
            'line_army' => $lineArmy,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
            'commander'=>$commander,
            'army'=>$army,
        ]);
    }

    /**
     * @Route("/{id}", name="app_line_army_delete", methods={"POST"})
     */
    public function delete(Request $request, LineArmy $lineArmy, LineArmyRepository $lineArmyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineArmy->getId(), $request->request->get('_token'))) {
            $lineArmyRepository->remove($lineArmy, true);
        }

        return $this->redirectToRoute('app_line_army_index', [], Response::HTTP_SEE_OTHER);
    }
}
