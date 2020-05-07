<?php

namespace App\Controller\admin;

use App\Repository\CompanyActualityRepository;
use App\Service\Pagination;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ManagerNewsController extends AbstractController
{
    const LIMIT_RESULT = 10;

    /**
     * @Route("/admin/gestion-news/{page}", name="manage_news", requirements={"page":"\d+"})
     */
    public function manageNews(CompanyActualityRepository $newsRepo, $page = 1, Pagination $pagination)
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        $totalNews = count($newsRepo->findAll());

        $pages = $pagination->numberPages($totalNews,self::LIMIT_RESULT);

        $allNews = $pagination->paginate(self::LIMIT_RESULT,$page,$newsRepo,'id','DESC');; 

        return $this->render('admin/manage_news.html.twig', [
            'allNews' => $allNews,
            'pages' => $pages
        ]);
    }
}
