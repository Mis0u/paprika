<?php

namespace App\Controller\admin;

use App\Entity\CompanyActuality;
use App\Form\CompanyActualityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditNewsController extends AbstractController
{
    /**
     * @Route("/edit/news/{id}", name="edit_news")
     */
    public function addNews(CompanyActuality $news,Request $request, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(CompanyActualityType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($news);
            $manager->flush();

            $this->addFlash("success", "Votre actualité a bien été modifié");
            return $this->redirectToRoute('manage_news');
        }

        return $this->render('admin/edit_news.html.twig', [
                'form' => $form->createView()
            ]);
    }
}
