<?php

namespace App\Controller;

use App\Entity\Mission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ValidateMissionController extends AbstractController
{
    /**
     * @Route("/mission/{id}", name="validate_mission")
     */
    public function index(Mission $mission, EntityManagerInterface $manager)
    {
        $mission->setIsValidate(1);
        $manager->persist($mission);
        $manager->flush();

        return $this->redirectToRoute('access_mission', ['slug'=>$this->getUser()->getSlug()]);
    }
}
