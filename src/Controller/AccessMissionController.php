<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccessMissionController extends AbstractController
{
    /**
     * @Route("/{slug}/mes-missions", name="access_mission")
     */
    public function index(User $user)
    {
        $this->denyAccessUnlessGranted("view", $user);

        return $this->render('access_mission/index.html.twig', [
            'user' => $user, 
        ]);
    }
}
