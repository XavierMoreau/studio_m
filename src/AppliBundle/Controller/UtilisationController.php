<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\Utilisation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Utilisation controller.
 *
 * @Route("utilisation")
 */
class UtilisationController extends Controller
{
    /**
     * Lists all utilisation entities.
     *
     * @Route("/", name="utilisation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $utilisations = $em->getRepository('AppliBundle:Utilisation')->findAll();

        return $this->render('utilisation/index.html.twig', array(
            'utilisations' => $utilisations,
        ));
    }

    /**
     * Creates a new utilisation entity.
     *
     * @Route("/new", name="utilisation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $utilisation = new Utilisation();
        $form = $this->createForm('AppliBundle\Form\UtilisationType', $utilisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisation);
            $em->flush($utilisation);

            return $this->redirectToRoute('utilisation_show', array('id' => $utilisation->getId()));
        }

        return $this->render('utilisation/new.html.twig', array(
            'utilisation' => $utilisation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a utilisation entity.
     *
     * @Route("/{id}", name="utilisation_show")
     * @Method("GET")
     */
    public function showAction(Utilisation $utilisation)
    {
        $deleteForm = $this->createDeleteForm($utilisation);

        return $this->render('utilisation/show.html.twig', array(
            'utilisation' => $utilisation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing utilisation entity.
     *
     * @Route("/{id}/edit", name="utilisation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Utilisation $utilisation)
    {
        $deleteForm = $this->createDeleteForm($utilisation);
        $editForm = $this->createForm('AppliBundle\Form\UtilisationType', $utilisation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisation_edit', array('id' => $utilisation->getId()));
        }

        return $this->render('utilisation/edit.html.twig', array(
            'utilisation' => $utilisation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a utilisation entity.
     *
     * @Route("/{id}", name="utilisation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Utilisation $utilisation)
    {
        $form = $this->createDeleteForm($utilisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisation);
            $em->flush($utilisation);
        }

        return $this->redirectToRoute('utilisation_index');
    }

    /**
     * Creates a form to delete a utilisation entity.
     *
     * @param Utilisation $utilisation The utilisation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Utilisation $utilisation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('utilisation_delete', array('id' => $utilisation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
