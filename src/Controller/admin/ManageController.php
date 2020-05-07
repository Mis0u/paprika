<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ManageController extends AbstractController
{
    /**
     * @Route("/admin/gestion", name="manage")
     */
    public function manage()
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        return $this->render('admin/manage.html.twig');
    }
}
