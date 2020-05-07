<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SendMissionController extends AbstractController
{
    const ERROR_404 = "Cet employé n'existe pas ou ne fais pas partie de votre équipe";
    const NOT_LEADER = "Seul le chef de votre équipe a accès à cette page";

    /**
     * @Route("/{slug}/assigner-mission/{employee}", name="send_mission")
     */
    public function index(User $user, UserRepository $userRepo,MissionRepository $missionRepo, string $employee, Request $request, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted("view", $user);
        $this->denyAccessUnlessGranted("leader", $user, self::NOT_LEADER);

        $userTeam = $userRepo->findBy(['slug' => $employee, 'workTeam' => $user->getWorkTeam(), 'isLeader' => false]);
        $userMission = $missionRepo->findByMission($userTeam[0]->getId(),1);
        $allMissionByUser = $missionRepo->findBy(['missionUser' => $userTeam[0]->getId()]);

        if (!$userTeam){
            throw new NotFoundHttpException(self::ERROR_404);
        }
        $mission = new Mission();
        $form = $this->createForm(MissionType::class,$mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $userTeam[0]->addMission($mission);
            $manager->persist($userTeam[0]);
            $manager->flush();

            $this->addFlash("success", "La mission a bien été assigné à <strong>{$userTeam[0]->getFullName()}</strong>");
            return $this->redirectToRoute('home', ['slug' => $user->getSlug()]);
        }

        return $this->render('send_mission/index.html.twig', [
            'form' => $form->createView(),
            'receiver' => $userTeam[0],
            'mission' => $userMission,
            'allMissionByUser' => $allMissionByUser
        ]);
    }
}
