<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\ScriptReponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Scriptreponse controller.
 *
 * @Route("scriptreponse")
 */
class ScriptReponseController extends Controller
{
    /**
     * Lists all scriptReponse entities.
     *
     * @Route("/", name="scriptreponse_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $scriptReponses = $em->getRepository('AppliBundle:ScriptReponse')->findAll();

        return $this->render('scriptreponse/index.html.twig', array(
            'scriptReponses' => $scriptReponses,
        ));
    }

    /**
     * Creates a new scriptReponse entity.
     *
     * @Route("/new", name="scriptreponse_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $scriptReponse = new Scriptreponse();
        $form = $this->createForm('AppliBundle\Form\ScriptReponseType', $scriptReponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scriptReponse);
            $em->flush($scriptReponse);

            return $this->redirectToRoute('scriptreponse_show', array('id' => $scriptReponse->getId()));
        }

        return $this->render('scriptreponse/new.html.twig', array(
            'scriptReponse' => $scriptReponse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a scriptReponse entity.
     *
     * @Route("/{id}", name="scriptreponse_show")
     * @Method("GET")
     */
    public function showAction(ScriptReponse $scriptReponse)
    {
        $deleteForm = $this->createDeleteForm($scriptReponse);

        return $this->render('scriptreponse/show.html.twig', array(
            'scriptReponse' => $scriptReponse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing scriptReponse entity.
     *
     * @Route("/{id}/edit", name="scriptreponse_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ScriptReponse $scriptReponse)
    {
        $deleteForm = $this->createDeleteForm($scriptReponse);
        $editForm = $this->createForm('AppliBundle\Form\ScriptReponseType', $scriptReponse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scriptreponse_edit', array('id' => $scriptReponse->getId()));
        }

        return $this->render('scriptreponse/edit.html.twig', array(
            'scriptReponse' => $scriptReponse,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a scriptReponse entity.
     *
     * @Route("/{id}", name="scriptreponse_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ScriptReponse $scriptReponse)
    {
        $form = $this->createDeleteForm($scriptReponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scriptReponse);
            $em->flush($scriptReponse);
        }

        return $this->redirectToRoute('scriptreponse_index');
    }

    /**
     * Creates a form to delete a scriptReponse entity.
     *
     * @param ScriptReponse $scriptReponse The scriptReponse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ScriptReponse $scriptReponse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('scriptreponse_delete', array('id' => $scriptReponse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
