<?php

namespace AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Doctrine\UserManager;


class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function adminAction()
    {

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')){

            return $this->render('AppliBundle:admin:admin.html.twig');

        }
        return $this->redirectToRoute('fos_user_security_login');

    }


    /**
     * @Route("/admin/users", name="users_index")
     */

    public function listeAction(){
        $userManager = $this->get('fos_user.user_manager');
        $this->users = $userManager->findUsers();


        return $this->render('AppliBundle:admin:userslist.html.twig',array(
            'users'     => $this->users,
        ));
    }


    /**
     * @Route("/admin/projets", name="projets_index")
     */

    public function projetsAction(){
        $em = $this->getDoctrine()->getManager();

        $projets = $em->getRepository('AppliBundle:Projet')->findAll();

        return $this->render('projet/index.html.twig', array(
            'projets' => $projets,
        ));
    }


}
