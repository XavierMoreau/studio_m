<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\expertType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Experttype controller.
 *
 * @Route("experttype")
 */
class expertTypeController extends Controller
{
    /**
     * Lists all expertType entities.
     *
     * @Route("/", name="experttype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $expertTypes = $em->getRepository('AppliBundle:expertType')->findAll();

        return $this->render('experttype/index.html.twig', array(
            'expertTypes' => $expertTypes,
        ));
    }

    /**
     * Creates a new expertType entity.
     *
     * @Route("/new", name="experttype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $expertType = new Experttype();
        $form = $this->createForm('AppliBundle\Form\expertTypeType', $expertType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expertType);
            $em->flush($expertType);

            return $this->redirectToRoute('experttype_index');
        }

        return $this->render('experttype/new.html.twig', array(
            'expertType' => $expertType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a expertType entity.
     *
     * @Route("/{id}", name="experttype_show")
     * @Method("GET")
     */
    public function showAction(expertType $expertType)
    {
        $deleteForm = $this->createDeleteForm($expertType);

        return $this->render('experttype/show.html.twig', array(
            'expertType' => $expertType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing expertType entity.
     *
     * @Route("/{id}/edit", name="experttype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, expertType $expertType)
    {
        $deleteForm = $this->createDeleteForm($expertType);
        $editForm = $this->createForm('AppliBundle\Form\expertTypeType', $expertType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('experttype_index');
        }

        return $this->render('experttype/edit.html.twig', array(
            'expertType' => $expertType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a expertType entity.
     *
     * @Route("/delete/{id}", name="experttype_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(expertType $expertType)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($expertType);
            $em->flush($expertType);


        return $this->redirectToRoute('experttype_index');
    }

    /**
     * Creates a form to delete a expertType entity.
     *
     * @param expertType $expertType The expertType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(expertType $expertType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('experttype_delete', array('id' => $expertType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
