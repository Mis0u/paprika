<?php

namespace App\Controller;

use App\Entity\ChangePassword;
use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ChangePasswordController extends AbstractController
{
    /**
     * @Route("/{slug}/change-password", name="change_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, User $user, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('view', $user);

        $changePassword = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $changePassword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user->setPassword($passwordEncoder->encodePassword($user,$changePassword->getNewPassword()));

            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success","Votre mot de passe a bien été modifié");
            return $this->redirectToRoute('home', ['slug' => $user->getSlug()]);
        }

        return $this->render('change_password/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
