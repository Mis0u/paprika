<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\CompanyActualityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/accueil/{slug}", name="home")
     */
    public function index(User $user, UserRepository $userRepository, CompanyActualityRepository $companyActualityRepo)
    {
        $this->denyAccessUnlessGranted('view', $user);

        $countAllUser = count($userRepository->findAll());
        $userSameTeam = $userRepository->findEmployeFromSameTeam($user->getWorkTeam()->getId(), false);
        $lastNews = $companyActualityRepo->findOneBy([],['id'=>'DESC']);
        $date = new \DateTime();
        return $this->render('home/accueil.html.twig', [
            'user' => $user,
            'count_all_user' => $countAllUser,
            'last_news' => $lastNews,
            'today_date' => $date,
            'user_same_team' => $userSameTeam
        ]);
    }
}
