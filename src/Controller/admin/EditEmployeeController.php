<?php

namespace App\Controller\admin;

use App\Entity\Team;
use App\Entity\User;
use App\Form\EditEmployeeType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EditEmployeeController extends AbstractController
{
    /**
     * @Route("/edit/employee/{id}", name="edit_employee")
     */
    public function edit(User $user,UserRepository $userRepo, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(EditEmployeeType::class, $user);
        $valueLeaderBeforeHandler = $user->getIsLeader();
        $form->handleRequest($request);

        $userSameTeam = $userRepo->findEmployeFromSameTeam($user->getWorkTeam()->getId(), false);

        if ($form->isSubmitted() && $form->isValid()){
            if ($user->getIsLeader() && $valueLeaderBeforeHandler === false){
                $team = new Team();
                $team->setLeaderFirstName($user->getFirstName())
                     ->setLeaderLastName($user->getLastName())
                     ->addUser($user);
                     
                $manager->persist($team);
            }elseif ($user->getIsLeader() == $valueLeaderBeforeHandler){
                $user->getWorkTeam()->setLeaderLastName($user->getLastName());
                $user->getWorkTeam()->setLeaderFirstName($user->getFirstName());
            }
            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "L'employé <strong>{$user->getFullName()}</strong> a bien été modifié");
            return $this->redirectToRoute('manage_user');
        }

        return $this->render('admin/edit_employee.html.twig', [
            'employee' => $user,
            'employeeSameTeam' => $userSameTeam,
            'form' => $form->createView()
        ]);
    }
}
