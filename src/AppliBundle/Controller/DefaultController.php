<?php

namespace AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {

        if ($this->get('security.context')->isGranted('ROLE_USER')){

            $user = $this->getUser();

            return $this->redirectToRoute('projet_index', array(
                'id' => $user->getId()));
        }
        return $this->redirectToRoute('fos_user_security_login');

    }


    /**
     * @Route("/unauth", name="unauthorized")
     */
    public function unauthAction()
    {

            return $this->render('AppliBundle:Default:unauthorized.html.twig');

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


}
