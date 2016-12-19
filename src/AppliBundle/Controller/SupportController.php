<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\Support;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Support controller.
 *
 * @Route("support")
 */
class SupportController extends Controller
{
    /**
     * Lists all support entities.
     *
     * @Route("/", name="support_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $supports = $em->getRepository('AppliBundle:Support')->findAll();

        return $this->render('support/index.html.twig', array(
            'supports' => $supports,
        ));
    }

    /**
     * Creates a new support entity.
     *
     * @Route("/new", name="support_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $support = new Support();
        $form = $this->createForm('AppliBundle\Form\SupportType', $support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($support);
            $em->flush($support);

            return $this->redirectToRoute('support_show', array('id' => $support->getId()));
        }

        return $this->render('support/new.html.twig', array(
            'support' => $support,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a support entity.
     *
     * @Route("/{id}", name="support_show")
     * @Method("GET")
     */
    public function showAction(Support $support)
    {
        $deleteForm = $this->createDeleteForm($support);

        return $this->render('support/show.html.twig', array(
            'support' => $support,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing support entity.
     *
     * @Route("/{id}/edit", name="support_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Support $support)
    {
        $deleteForm = $this->createDeleteForm($support);
        $editForm = $this->createForm('AppliBundle\Form\SupportType', $support);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('support_edit', array('id' => $support->getId()));
        }

        return $this->render('support/edit.html.twig', array(
            'support' => $support,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a support entity.
     *
     * @Route("/{id}", name="support_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Support $support)
    {
        $form = $this->createDeleteForm($support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($support);
            $em->flush($support);
        }

        return $this->redirectToRoute('support_index');
    }

    /**
     * Creates a form to delete a support entity.
     *
     * @param Support $support The support entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Support $support)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('support_delete', array('id' => $support->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
