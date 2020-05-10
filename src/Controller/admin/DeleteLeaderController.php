<?php

namespace App\Controller\admin;

use App\Entity\Team;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteLeaderController extends AbstractController
{
    /**
     * @Route("/admin/delete-leader/{id}", name="delete_leader")
     */
    public function deleteLeader(User $user, EntityManagerInterface $manager)
    {

        $user->setIsLeader(0);
        $manager->persist($user);
        
        $manager->flush();

       
        $this->addFlash("success", "L'utilisateur n'est désormais plus leader");
        return $this->redirectToRoute("manage_user");

    }

}
