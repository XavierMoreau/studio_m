<?php

namespace AppliBundle\Controller;

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
        if ($user === $this->getUser()){
            $em = $this->getDoctrine()->getManager();

            $projets = $em->getRepository('AppliBundle:Projet')->findByUtilisateur($user);

            return $this->render('projet/index.html.twig', array(
                'projets' => $projets,
            ));
        }
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }

    /**
     * Creates a new projet entity.
     *
     * @Route("/{id}/new", name="projet_new")
     *
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, User $user)
    {
        if ($user === $this->getUser()){
        $projet = new Projet();
        $projet->setUtilisateur($user);
        $form = $this->createForm('AppliBundle\Form\ProjetType', $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($projet);
            $em->flush($projet);

            return $this->redirectToRoute('projet_show', array('id' => $user->getId(), 'projet' => $projet->getId()));
        }

        return $this->render('projet/new.html.twig', array(
            'user' => $user,
            'projet' => $projet,
            'form' => $form->createView(),
        ));
        }
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }

    /**
     * Finds and displays a projet entity.
     *
     * @Route("/{id}/{projet}", name="projet_show")
     * @Method("GET")
     */
    public function showAction(User $user, Projet $projet)
    {
        if ($user === $this->getUser()){

        $deleteForm = $this->createDeleteForm($projet, $user);

        return $this->render('projet/show.html.twig', array(
            'user' => $user,
            'projet' => $projet,
            'delete_form' => $deleteForm->createView(),
        ));
        }
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }

    /**
     * Displays a form to edit an existing projet entity.
     *
     * @Route("/{id}/{projet}/edit", name="projet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(User $user, Request $request, Projet $projet)
    {
        if ($user === $this->getUser()){
        $deleteForm = $this->createDeleteForm($projet, $user);
        $editForm = $this->createForm('AppliBundle\Form\ProjetType', $projet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projet_show', array('id' => $user->getId(),'projet' => $projet->getId()));
        }

        return $this->render('projet/edit.html.twig', array(
            'user' => $user,
            'projet' => $projet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
        }
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }

    /**
     * Deletes a projet entity.
     *
     * @Route("/{id}/{projet}", name="projet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(User $user, Request $request, Projet $projet)
    {
        $form = $this->createDeleteForm($projet, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($projet);
            $em->flush($projet);
        }

        return $this->redirectToRoute('projet_index', array('id' => $user->getId()));
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
