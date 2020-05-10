<?php

namespace App\Controller\admin;

use App\Repository\TeamRepository;
use App\Service\Pagination;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ManageUserController extends AbstractController
{
    const LIMIT_RESULT = 10;

    /**
     * @Route("/admin/gestion-employes/{page}", name="manage_user", requirements={"page":"\d+"})
     */
    public function manageUser(UserRepository $userRepo, $page = 1, Pagination $pagination, Request $request, TeamRepository $teamRepo)
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        $totalEmployee = count($userRepo->findAll());

        $pages = $pagination->numberPages($totalEmployee,self::LIMIT_RESULT);

        $allEmployee = $pagination->paginate(self::LIMIT_RESULT,$page,$userRepo,'lastName','ASC');

        $team = $teamRepo->findBy(["isBoss" => true]);

        if ($request->get('user')){
            $allEmployee = $userRepo->findEmploye($request->get('user'));
            $pages = $pagination->numberPages(count($allEmployee),self::LIMIT_RESULT);
        }
        
        return $this->render('admin/manage_user.html.twig', [
            'allEmployee' => $allEmployee,
            'pages' => $pages,
            'team' => $team
        ]);
    }
}
