<?php

namespace App\Controller;

use App\Entity\Army;
use App\Form\ArmyType;
use App\Entity\LineNCU;
use App\Entity\LineArmy;
use App\Form\ArmyEditType;
use App\Form\LineArmyType;
use App\Form\SelectCUType;
use App\Repository\ArmyRepository;
use App\Repository\RegionRepository;
use App\Repository\LineNCURepository;
use App\Repository\LineArmyRepository;
use App\Repository\CombatUnitRepository;
use App\Repository\NoCombatUnitRepository;
use App\Repository\NotificationRepository;
use App\Repository\LineCommanderRepository;
use App\Repository\LineAttachmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/army")
 */
class ArmyController extends AbstractController
{
    /**
     * @Route("/", name="app_army_index", methods={"GET"})
     */
    public function index(ArmyRepository $armyRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {       $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
            $regions = $regionRepository->findAll();
            $user = $this->getUser();
        return $this->render('army/index.html.twig', [
            'armies' => $armyRepository->findAll(),
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/new", name="app_army_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ArmyRepository $armyRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, LineArmyRepository $lineArmyRepository, CombatUnitRepository $combatUnitRepository): Response
    {
        $qty = 0;   
        $lineArmy = new LineArmy();
        $army = new Army();
        $form = $this->createForm(ArmyType::class, $army);
        $form->handleRequest($request);

        $totalCost = 0;
   
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();

        






        $btnAddSecondaryStuff = $form->get('secondary_stuff_add_btn');
        $btnAddTertiaryStuff = $form->get('tertiary_stuff_add_btn');
        $btnAddQuatroStuff = $form->get('quatro_stuff_add_btn');

            if($form->isSubmitted() && $form->isValid()) {



                    if ($btnAddSecondaryStuff->isClicked()) {
                        $army->setArmyUser($user);
                        $army->setStatus(false);
                                   
                        $armyRepository->add($army, true);

                        //$myCUtable = $army->getLinkCombatUnit();
                        //$myCUid = end($myCUtable);
                        $lastArmy= $armyRepository->findBy(['armyUser'=>$user],array('id'=>'DESC'),1,0);
                        $lastArmyOk = $lastArmy[0];

                        $myCUtable = $lastArmyOk->getLinkCombatUnit();

                        $mylastCu=$myCUtable[count($myCUtable)-1];
                        $myCUid=$mylastCu->getId();


                       $mygoodCu = $combatUnitRepository->findOneBy(['id'=>$myCUid]);
                    //    $myCuCost = $mygoodCu->getCost();
                    //    $ArmyTotalCost = $army->setTotalCost($myCuCost);

                        //$lastArmyCU = $lastArmy[10];
                        $lastArmyId = $lastArmyOk->getId();

                       //$myCU = $combatUnitRepository->findOneBy(['id'=>$myCUid['id']]);
                       //$myCU= $combatUnitRepository->findBy(['id'=>$myCUid],array('id'=>'DESC'),1,0);
                        $lineArmy->setQuantity($qty+1);

                        $lineArmy->setArmy($lastArmyOk);
                        $lineArmy->setCombatUnit($mygoodCu);
  
                        //$armyRepository->add($army, true);
                        $lineArmyRepository->add($lineArmy, true);
                        return $this->redirectToRoute('app_army_edit', ['id' => $army->getId()], Response::HTTP_SEE_OTHER); 
                   }
                   if ($btnAddTertiaryStuff->isClicked()) {
                    $army->setArmyUser($user);
                    $army->setStatus(false);
                    $lastArmy= $armyRepository->findBy(['armyUser'=>$user],array('id'=>'DESC'),1,0);
                    $lastArmyOk = $lastArmy[0];
                    $myNCUtable = $army->getLinkNCU();
                    $mylastNCU = $myNCUtable[count($myNCUtable)-1];
                    $myNCUid = $mylastNCU->getId();
                    $mygoodNCU = $noCombatUnitRepository->findOneBy(['id'=>$myNCUid]);
                    $lineNCU->setArmy($army);
                    $lineNCU->setNoCombatUnit($mygoodNCU);
                    $lineNCURepository->add($lineNCU, true);
                    return $this->redirectToRoute('app_army_edit', ['id' => $army->getId()], Response::HTTP_SEE_OTHER); 
                   }
                   if ($btnAddQuatroStuff->isClicked()) {
                   $army->setArmyUser($user);
                   $army->setStatus(false);
                   $armyRepository->add($army, true);
                   return $this->redirectToRoute('app_army_edit', ['id' => $army->getId()], Response::HTTP_SEE_OTHER); 

                   }
                return $this->redirectToRoute('app_army_index', [], Response::HTTP_SEE_OTHER);
            }
            
        
        return $this->renderForm('army/new.html.twig', [
                'form' => $form,
                'army' => $army,
                'lineArmy' => $lineArmy,
                'notifmenu'=>$notifmenu,
                'regions' => $regions,
                'user' => $user,
             
            ]
        );
    }

        // if ($form->isSubmitted() && $form->isValid()) {

        //     $army->setArmyUser($user);
        //     $army->setStatus(false);            
        //     $armyRepository->add($army, true);
            
 
            /*if ($btnAddSecondaryStuff->isClicked()) {
                return $this->redirectToRoute('app_army_index', [], Response::HTTP_SEE_OTHER);
            } */
            // return $this->redirectToRoute('app_army_edit', ['id' => $army->getId()], Response::HTTP_SEE_OTHER);
        //     return $this->redirectToRoute('app_army_index', [], Response::HTTP_SEE_OTHER);
        // }


    //     return $this->renderForm('army/new.html.twig', [
    //         'army' => $army,

    //         'form' => $form,
    //         'regions' => $regions,
    //         'user' => $user,
    //         'notifmenu'=>$notifmenu,
    //     ]);
    // }

    /**
     * @Route("/{id}", name="app_army_show", methods={"GET"})
     */
    public function show(Army $army, RegionRepository $regionRepository, NotificationRepository $notificationRepository): Response
    {
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        return $this->render('army/show.html.twig', [
            'army' => $army,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_army_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Army $army, ArmyRepository $armyRepository, RegionRepository $regionRepository, NotificationRepository $notificationRepository, LineArmyRepository $lineArmyRepository, CombatUnitRepository $combatUnitRepository, LineAttachmentRepository $lineAttachmentRepository, NoCombatUnitRepository $noCombatUnitRepository, LineNCURepository $lineNCURepository, LineCommanderRepository $lineCommanderRepository): Response
    {     
        $qty = 0;        
        $lineArmy = new LineArmy();
        $lineNCU = new LineNCU();
        $notifmenu = $notificationRepository->findBy(['statut'=>'non lu','addressee'=>$this->getUser()]);
        $regions = $regionRepository->findAll();
        $user = $this->getUser();
        $form = $this->createForm(ArmyEditType::class, $army);
        $form->handleRequest($request);
        $btnAddSecondaryStuff = $form->get('secondary_stuff_add_btn');
        $btnAddTertiaryStuff = $form->get('tertiary_stuff_add_btn');
        $lineArmies = $lineArmyRepository->findBy(['army'=>$army]);
        $lineNCUs = $lineNCURepository->findBy(['army'=>$army]);
        $lineAttachments = $lineAttachmentRepository->findBy(['army'=>$army]);
        $lineCommander = $lineCommanderRepository->findBy(['army'=>$army]);
        $combatUnits = $combatUnitRepository->findAll();

        $totalCostArray = [];

$myCuTable2 = $army->getlinkCombatUnit();

foreach($lineArmies as $value){
    $myCu2 = $value->getCombatUnit();
    $myCuCost = $myCu2->getCost();
    array_push($totalCostArray, $myCuCost);
    var_dump($myCuCost);
}
foreach($lineAttachments as $value2){
    $myAttachment = $value2->getAttachment();

    $myAttachmentCost = $myAttachment->getcost();
    array_push($totalCostArray, $myAttachmentCost);
}
foreach($lineNCUs as $value3){
    $myNCU = $value3->getNoCombatUnit();

    $myNCUcost = $myNCU->getcost();
    array_push($totalCostArray, $myNCUcost);
}

$totalCostCu = array_sum($totalCostArray);






        if ($form->isSubmitted() && $form->isValid()) {
                    if ($btnAddSecondaryStuff->isClicked()) {


                        //$myCUtable = $army->getLinkCombatUnit();
                        //$myCUid = end($myCUtable);


                        $myCUtable = $army->getLinkCombatUnit();

                       //$myCUid = $myCUtable[0]->getId();
                        $mylastCu=$myCUtable[count($myCUtable)-1];
                        $myCUid=$mylastCu->getId();

                       $mygoodCu = $combatUnitRepository->findOneBy(['id'=>$myCUid]);

                        //$lastArmyCU = $lastArmy[10];
                        //$lastArmyId = $lastArmyOk->getId();

                       //$myCU = $combatUnitRepository->findOneBy(['id'=>$myCUid['id']]);
                       //$myCU= $combatUnitRepository->findBy(['id'=>$myCUid],array('id'=>'DESC'),1,0);
                        $lineArmy->setQuantity($qty+1);

                        $lineArmy->setArmy($army);
                        $lineArmy->setCombatUnit($mygoodCu);
  
                        $lineArmyRepository->add($lineArmy, true);
                        return $this->redirectToRoute('app_army_edit', ['id' => $army->getId()], Response::HTTP_SEE_OTHER); 
                   }
                   if ($btnAddTertiaryStuff->isClicked()) {
                    $myNCUtable = $army->getLinkNCU();
                    $mylastNCU = $myNCUtable[count($myNCUtable)-1];
                    $myNCUid = $mylastNCU->getId();
                    $mygoodNCU = $noCombatUnitRepository->findOneBy(['id'=>$myNCUid]);
                    $lineNCU->setArmy($army);
                    $lineNCU->setNoCombatUnit($mygoodNCU);
                    $lineNCURepository->add($lineNCU, true);
                    return $this->redirectToRoute('app_army_edit', ['id' => $army->getId()], Response::HTTP_SEE_OTHER); 
                   }
                   if ($btnAddQuatroStuff->isClicked()) {
                    $army->setArmyUser($user);
                    $army->setStatus(false);
                    $armyRepository->add($army, true);
                    return $this->redirectToRoute('app_army_edit', ['id' => $army->getId()], Response::HTTP_SEE_OTHER); 
 
                    }
            return $this->redirectToRoute('app_army_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('army/edit.html.twig', [
            'army' => $army,
            'form' => $form,
            'regions' => $regions,
            'user' => $user,
            'notifmenu'=>$notifmenu,
            'lineArmies'=>$lineArmies,
            'combatUnits'=>$combatUnits,
            'lineAttachments'=>$lineAttachments,
            'totalCostCu'=>$totalCostCu,
            'lineNCUs'=>$lineNCUs,
            'lineCommander'=>$lineCommander,
        ]);
    }
    

    /**
     * @Route("/{id}", name="app_army_delete", methods={"POST"})
     */
    public function delete(Request $request, Army $army, ArmyRepository $armyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$army->getId(), $request->request->get('_token'))) {
            $armyRepository->remove($army, true);
        }

        return $this->redirectToRoute('app_army_index', [], Response::HTTP_SEE_OTHER);
    }
}
