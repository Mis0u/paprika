<?php

namespace App\Controller\admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteEmployeeController extends AbstractController
{
    /**
     * @Route("/admin/delete-employee/{id}", name="delete_employee")
     */
    public function delete(User $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash("success","L'employé <strong>{$user->getFullName()}</strong> a bien été supprimé");
        return $this->redirectToRoute("manage_user");
    }
}
