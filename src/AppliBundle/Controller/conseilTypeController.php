<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\conseilType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Conseiltype controller.
 *
 * @Route("conseiltype")
 */
class conseilTypeController extends Controller
{
    /**
     * Lists all conseilType entities.
     *
     * @Route("/", name="conseiltype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conseilTypes = $em->getRepository('AppliBundle:conseilType')->findAll();
        $expertType = $em->getRepository('AppliBundle:expertType')->findAll();

        return $this->render('conseiltype/index.html.twig', array(
            'conseilTypes' => $conseilTypes,
            'expertType' => $expertType,
        ));
    }

    /**
     * Creates a new conseilType entity.
     *
     * @Route("/new", name="conseiltype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $conseilType = new Conseiltype();
        $form = $this->createForm('AppliBundle\Form\conseilTypeType', $conseilType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conseilType);
            $em->flush($conseilType);

            return $this->redirectToRoute('conseiltype_index');
        }

        return $this->render('conseiltype/new.html.twig', array(
            'conseilType' => $conseilType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a conseilType entity.
     *
     * @Route("/{id}", name="conseiltype_show")
     * @Method("GET")
     */
    public function showAction(conseilType $conseilType)
    {
        $deleteForm = $this->createDeleteForm($conseilType);

        return $this->render('conseiltype/show.html.twig', array(
            'conseilType' => $conseilType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing conseilType entity.
     *
     * @Route("/{id}/edit", name="conseiltype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, conseilType $conseilType)
    {
        $deleteForm = $this->createDeleteForm($conseilType);
        $editForm = $this->createForm('AppliBundle\Form\conseilTypeType', $conseilType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conseiltype_index');
        }

        return $this->render('conseiltype/edit.html.twig', array(
            'conseilType' => $conseilType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a conseilType entity.
     *
     * @Route("/delete/{id}", name="conseiltype_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(conseilType $conseilType)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($conseilType);
            $em->flush($conseilType);


        return $this->redirectToRoute('conseiltype_index');
    }

    /**
     * Creates a form to delete a conseilType entity.
     *
     * @param conseilType $conseilType The conseilType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(conseilType $conseilType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('conseiltype_delete', array('id' => $conseilType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
