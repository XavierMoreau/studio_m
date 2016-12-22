<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\ScriptEcriture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Scriptecriture controller.
 *
 * @Route("scriptecriture")
 */
class ScriptEcritureController extends Controller
{
    /**
     * Lists all scriptEcriture entities.
     *
     * @Route("/", name="scriptecriture_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $scriptEcritures = $em->getRepository('AppliBundle:ScriptEcriture')->findAll();

        return $this->render('scriptecriture/index.html.twig', array(
            'scriptEcritures' => $scriptEcritures,
        ));
    }

    /**
     * Creates a new scriptEcriture entity.
     *
     * @Route("/new", name="scriptecriture_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $scriptEcriture = new Scriptecriture();
        $form = $this->createForm('AppliBundle\Form\ScriptEcritureType', $scriptEcriture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scriptEcriture);
            $em->flush($scriptEcriture);

            return $this->redirectToRoute('scriptecriture_show', array('id' => $scriptEcriture->getId()));
        }

        return $this->render('scriptecriture/new.html.twig', array(
            'scriptEcriture' => $scriptEcriture,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a scriptEcriture entity.
     *
     * @Route("/{id}", name="scriptecriture_show")
     * @Method("GET")
     */
    public function showAction(ScriptEcriture $scriptEcriture)
    {
        $deleteForm = $this->createDeleteForm($scriptEcriture);

        return $this->render('scriptecriture/show.html.twig', array(
            'scriptEcriture' => $scriptEcriture,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing scriptEcriture entity.
     *
     * @Route("/{id}/edit", name="scriptecriture_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ScriptEcriture $scriptEcriture)
    {
        $deleteForm = $this->createDeleteForm($scriptEcriture);
        $editForm = $this->createForm('AppliBundle\Form\ScriptEcritureType', $scriptEcriture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scriptecriture_edit', array('id' => $scriptEcriture->getId()));
        }

        return $this->render('scriptecriture/edit.html.twig', array(
            'scriptEcriture' => $scriptEcriture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a scriptEcriture entity.
     *
     * @Route("/{id}", name="scriptecriture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ScriptEcriture $scriptEcriture)
    {
        $form = $this->createDeleteForm($scriptEcriture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scriptEcriture);
            $em->flush($scriptEcriture);
        }

        return $this->redirectToRoute('scriptecriture_index');
    }

    /**
     * Creates a form to delete a scriptEcriture entity.
     *
     * @param ScriptEcriture $scriptEcriture The scriptEcriture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ScriptEcriture $scriptEcriture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('scriptecriture_delete', array('id' => $scriptEcriture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
