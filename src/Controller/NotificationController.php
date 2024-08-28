<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Form\NotificationType;
use App\Repository\RegionRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/notification")
 */
class NotificationController extends AbstractController
{
    /**
     * @Route("/", name="app_notification_index", methods={"GET"})
     */
    public function index(NotificationRepository $notificationRepository, RegionRepository $regionRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('notification/index.html.twig', [
            'notifications' => $notificationRepository->findAll(),
            'regions' => $regions,
            'user' => $user,
             'notifmenu'=>$notifmenu,
        ]);
    }    
    /**
    * @Route("/archive", name="app_notification_archive", methods={"GET"})
    */
   public function archive(NotificationRepository $notificationRepository, RegionRepository $regionRepository): Response
   {    
    $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
    $regions = $regionRepository->findAll();
    $user = $this->getUser();
        return $this->render('notification/archive.html.twig', [
           'notifications' => $notificationRepository->findAll(),
           'user'=> $user,
           'regions' => $regions,
       
            'notifmenu'=>$notifmenu,
       ]);
   }

    /**
     * @Route("/new", name="app_notification_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NotificationRepository $notificationRepository): Response
    {
        $notification = new Notification();
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificationRepository->add($notification, true);

            return $this->redirectToRoute('app_notification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notification/new.html.twig', [
            'notification' => $notification,
            'form' => $form,

        ]);
    }

    /**
     * @Route("/{id}", name="app_notification_show", methods={"GET", "POST"})
     */
    public function show_notif(Request $request, Notification $notification, NotificationRepository $notificationRepository, RegionRepository $regionRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            


            $notificationRepository->add($notification, true);

            return $this->redirectToRoute('app_notification_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderform('notification/show.html.twig', [
            'notification' => $notification,
            'regions' => $regions,
            'user' => $user,
             'notifmenu'=>$notifmenu,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_notification_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Notification $notification, NotificationRepository $notificationRepository): Response
    {
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificationRepository->add($notification, true);

            return $this->redirectToRoute('app_notification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notification/edit.html.twig', [
            'notification' => $notification,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_notification_delete", methods={"POST"})
     */
    public function delete(Request $request, Notification $notification, NotificationRepository $notificationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notification->getId(), $request->request->get('_token'))) {
            $notificationRepository->remove($notification, true);
        }

        return $this->redirectToRoute('app_notification_index', [], Response::HTTP_SEE_OTHER);
    }
}
