<?php

namespace App\Controller\admin;

use App\Entity\CompanyActuality;
use App\Form\CompanyActualityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WriteANewsController extends AbstractController
{
    /**
     * @Route("/admin/ajouter-une-actualite", name="add_news")
     */
    public function addNews(Request $request, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $news = new CompanyActuality();
        $form = $this->createForm(CompanyActualityType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($news);
            $manager->flush();

            $this->addFlash("success", "Votre actualité a bien été ajouté");
            return $this->redirectToRoute('home', ['slug' => $this->getUser()->getSlug()]);
        }

        return $this->render('admin/write_a_news.html.twig', [
                'form' => $form->createView()
            ]);
    }
}
