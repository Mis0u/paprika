<?php

namespace App\Controller\admin;

use App\Service\Pagination;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ManageUserController extends AbstractController
{
    const LIMIT_RESULT = 10;

    /**
     * @Route("/admin/gestion-employes/{page}", name="manage_user", requirements={"page":"\d+"})
     */
    public function manageUser(UserRepository $userRepo, $page = 1, Pagination $pagination)
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        $totalEmployee = count($userRepo->findAll());

        $pages = $pagination->numberPages($totalEmployee,self::LIMIT_RESULT);

        $allEmployee = $pagination->paginate(self::LIMIT_RESULT,$page,$userRepo,'lastName','ASC');; 

        return $this->render('admin/manage_user.html.twig', [
            'allEmployee' => $allEmployee,
            'pages' => $pages
        ]);
    }
}
