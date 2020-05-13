<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\MissionRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccessMissionController extends AbstractController
{
    /**
     * @Route("/{slug}/mes-missions", name="access_mission")
     */
    public function index(User $user, MissionRepository $missionRepo)
    {
        $this->denyAccessUnlessGranted("view", $user);

        $gotMissions = $missionRepo->findBy(['missionUser' => $user->getId(), 'isValidate' => 0]);

        return $this->render('access_mission/missions.html.twig', [
            'user' => $user,
            'missions' => $gotMissions
        ]);
    }
}
