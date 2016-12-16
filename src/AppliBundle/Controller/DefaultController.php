<?php

namespace AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {

        if ($this->get('security.context')->isGranted('ROLE_USER')){

            return $this->render('AppliBundle:Default:index.html.twig');

        }
        return $this->redirectToRoute('fos_user_security_login');

    }




    /**
     * @Route("/expert", name="expert_control")
     */
    public function expertAction()
    {

        if ($this->get('security.context')->isGranted('ROLE_USER') AND $this->getUser()->getUserExpert() == true){

        return $this->render('AppliBundle:Default:expert.html.twig');
        }
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/contributeur", name="contributeur_control")
     */
    public function contributeurAction()
    {
        return $this->render('AppliBundle:Default:contributeur.html.twig');
    }

    /**
     * @Route("/admin", name="admin_control")
     */
    public function adminAction()
    {
        return $this->render('AppliBundle:Default:admin.html.twig');
    }


}
