<?php

namespace App\Controller;

use App\Form\UserType;
use App\Form\UserClientEditType;
use App\Repository\UserRepository;
use App\Repository\RegionRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        
         
        $user = $this->getUser();
 
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu
            
        ]);
    }

    /**
     * @Route("/profile", name="app_user_profile", methods={"GET", "POST"})
     */
    public function profile(Request $request, UserRepository $userRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]); 
        $user = $this->getUser();
        $regions = $regionRepository->findAll();
        $form = $this->createForm(UserClientEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'regions' => $regions,
            'form' => $form,
            'notifmenu'=>$notifmenu
            
        ]);
    }
     /**
     * @Route("/rgpd", name="app_rgpd", methods={"GET", "POST"})
     */
    public function rgpd(RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]); 
        $user = $this->getUser();
        $regions = $regionRepository->findAll();
 

  

        return $this->render('home/rgpd.html.twig', [
            'user' => $user,
            'regions' => $regions,
    
            'notifmenu'=>$notifmenu
            
        ]);
    }
}
