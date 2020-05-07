<?php

namespace App\Controller\admin;

use App\Entity\Team;
use App\Entity\User;
use App\Form\EditEmployeeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditEmployeeController extends AbstractController
{
    /**
     * @Route("/edit/employee/{id}", name="edit_employee")
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(EditEmployeeType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if ($user->getIsLeader()){
                $team = new Team();
                $team->setLeaderLastName(ucfirst($user->getLastName()))
                     ->setLeaderFirstName(ucfirst($user->getFirstName()))
                     ->addUser($user);
                $manager->persist($team);
            }
            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "L'employé <strong>{$user->getFullName()}</strong> a bien été modifié");
            return $this->redirectToRoute('manage_user');
        }

        return $this->render('admin/edit_employee.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
