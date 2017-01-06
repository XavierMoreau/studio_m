<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\Diffusion;
use AppliBundle\Entity\Script;
use AppliBundle\Entity\Utilisation;
use AppliBundle\Entity\Support;
use AppliBundle\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

/**
 * Projet controller.
 *
 * @Route("projet")
 */
class ProjetController extends Controller
{
    /**
     * Lists all projet entities.
     *
     * @Route("/{id}", name="projet_index")
     * @Method("GET")
     */
    public function indexAction(User $user)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()){

            //Récupération des données du projet et données liées
            $em = $this->getDoctrine()->getManager();

            $projets = $em->getRepository('AppliBundle:Projet')->findByUtilisateur($user);
            $datas = $em->getRepository('AppliBundle:Projet')->getSupports();
            $datas = $em->getRepository('AppliBundle:Projet')->getDiffusions();
            $datas = $em->getRepository('AppliBundle:Projet')->getUtilisations();

            return $this->render('projet/index.html.twig', array(
                'projets' => $projets,
                'datas' => $datas,

            ));
        }

        // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }

    /**
     * Creates a new projet entity with user ID
     *
     * @Route("/{id}/new", name="projet_new")
     *
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, User $user)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()){

            // Création du nouveau projet
            $projet = new Projet();
            $script = new Script();

            // Attribution de l'utilisateur au projet
            $projet->setUtilisateur($user);
            $projet->setScript($script);

            // Formulaire de création du projet
            $form = $this->createForm('AppliBundle\Form\ProjetType', $projet);
            $form->handleRequest($request);

            // Si Formulaire valide, on persiste dans la BD
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($projet);
                $em->flush($projet);

                // et on renvoie vers la création du script
                return $this->redirectToRoute('script_index', array(
                    'id' => $user->getId(),
                    'projet' => $projet->getId(),
                    'script' => $script->getId(),
                ));
            }

            // Si formulaire invalide, on recommence
            return $this->render('projet/new.html.twig', array(
                'user' => $user->getId(),
                'projet' => $projet->getId(),
                'form' => $form->createView(),
            ));
            }

        // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }
//
//    /**
//     * Finds and displays a projet entity.
//     *
//     * @Route("/{id}/{projet}", name="projet_show")
//     * @Method("GET")
//     */
//    public function showAction(User $user, Projet $projet)
//    {
//        if ($user === $this->getUser()){
//
//        $deleteForm = $this->createDeleteForm($projet, $user);
//
//        return $this->render('projet/show.html.twig', array(
//            'user' => $user,
//            'projet' => $projet,
//            'delete_form' => $deleteForm->createView(),
//        ));
//        }
//        else{
//            return $this->render('AppliBundle:Default:unauthorized.html.twig');
//        }
//    }

    /**
     * Displays a form to edit an existing projet entity.
     *
     * @Route("/{id}/{projet}/edit", name="projet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(User $user, Request $request, Projet $projet)
    {

        // Controle de l'utilisateur
        if ($user === $this->getUser()){


//        $deleteForm = $this->createDeleteForm($projet, $user);
            // création du formulaire avec données remplies
            $editForm = $this->createForm('AppliBundle\Form\ProjetType', $projet);
            $editForm->handleRequest($request);

            // si formulaire valide on modifie les données dans la BDD
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                // et on redirige vers la liste des projets
                return $this->redirectToRoute('projet_index', array('id' => $user->getId()));
        }
            // sinon formulaire non valide on reessaie
            return $this->render('projet/edit.html.twig', array(
                'user' => $user,
                'projet' => $projet,
                'edit_form' => $editForm->createView(),
//                'delete_form' => $deleteForm->createView(),
        ));
        }
        // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }

    /**
     * Deletes a projet entity.
     *
     * @Route("/delete/{id}/{projet}", name="projet_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(User $user, Request $request, Projet $projet)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()){

            // Suppression dans la BDD du projet séléctionné
            $em = $this->getDoctrine()->getManager();
            $em->remove($projet);
            $em->flush($projet);
            // et on redirige vers la liste des projets
            return $this->redirectToRoute('projet_index', array('id' => $user->getId()));
        }
        // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }


    /**
     * Creates a form to delete a projet entity.
     *
     * @param Projet $projet The projet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Projet $projet, User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('projet_delete', array('id' => $user->getId(), 'projet' => $projet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
