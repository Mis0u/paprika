<?php

namespace App\Controller\admin;

use App\Entity\CompanyActuality;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteNewsController extends AbstractController
{
    /**
     * @Route("/admin/delete-news/{id}", name="delete_news")
     */
    public function delete(CompanyActuality $news, EntityManagerInterface $manager)
    {
        $manager->remove($news);
        $manager->flush();

        $this->addFlash("success","L'actualité <strong>{$news->getId()}</strong> a bien été supprimé");
        return $this->redirectToRoute("manage_news");
    }
}
