<?php

namespace AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function adminAction()
    {

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')){

            return $this->render('AppliBundle:Default:admin.html.twig');

        }
        return $this->redirectToRoute('fos_user_security_login');

    }








}
