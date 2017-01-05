<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\conseil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Conseil controller.
 *
 * @Route("conseil")
 */
class conseilController extends Controller
{
    /**
     * Lists all conseil entities.
     *
     * @Route("/", name="conseil_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conseils = $em->getRepository('AppliBundle:conseil')->findAll();

        return $this->render('conseil/index.html.twig', array(
            'conseils' => $conseils,
        ));
    }

    /**
     * Creates a new conseil entity.
     *
     * @Route("/new", name="conseil_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $conseil = new Conseil();
        $form = $this->createForm('AppliBundle\Form\conseilType', $conseil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conseil);
            $em->flush($conseil);

            return $this->redirectToRoute('conseil_show', array('id' => $conseil->getId()));
        }

        return $this->render('conseil/new.html.twig', array(
            'conseil' => $conseil,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a conseil entity.
     *
     * @Route("/{id}", name="conseil_show")
     * @Method("GET")
     */
    public function showAction(conseil $conseil)
    {
        $deleteForm = $this->createDeleteForm($conseil);

        return $this->render('conseil/show.html.twig', array(
            'conseil' => $conseil,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing conseil entity.
     *
     * @Route("/{id}/edit", name="conseil_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, conseil $conseil)
    {
        $deleteForm = $this->createDeleteForm($conseil);
        $editForm = $this->createForm('AppliBundle\Form\conseilType', $conseil);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conseil_edit', array('id' => $conseil->getId()));
        }

        return $this->render('conseil/edit.html.twig', array(
            'conseil' => $conseil,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a conseil entity.
     *
     * @Route("/{id}", name="conseil_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, conseil $conseil)
    {
        $form = $this->createDeleteForm($conseil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($conseil);
            $em->flush($conseil);
        }

        return $this->redirectToRoute('conseil_index');
    }

    /**
     * Creates a form to delete a conseil entity.
     *
     * @param conseil $conseil The conseil entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(conseil $conseil)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('conseil_delete', array('id' => $conseil->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
