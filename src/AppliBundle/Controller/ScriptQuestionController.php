<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\ScriptQuestion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Scriptquestion controller.
 *
 * @Route("scriptquestion")
 */
class ScriptQuestionController extends Controller
{
    /**
     * Lists all scriptQuestion entities.
     *
     * @Route("/", name="scriptquestion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $scriptQuestions = $em->getRepository('AppliBundle:ScriptQuestion')->findAll();

        return $this->render('scriptquestion/index.html.twig', array(
            'scriptQuestions' => $scriptQuestions,
        ));
    }

    /**
     * Creates a new scriptQuestion entity.
     *
     * @Route("/new", name="scriptquestion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $scriptQuestion = new Scriptquestion();
        $form = $this->createForm('AppliBundle\Form\ScriptQuestionType', $scriptQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scriptQuestion);
            $em->flush($scriptQuestion);

            return $this->redirectToRoute('scriptquestion_show', array('id' => $scriptQuestion->getId()));
        }

        return $this->render('scriptquestion/new.html.twig', array(
            'scriptQuestion' => $scriptQuestion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a scriptQuestion entity.
     *
     * @Route("/{id}", name="scriptquestion_show")
     * @Method("GET")
     */
    public function showAction(ScriptQuestion $scriptQuestion)
    {
        $deleteForm = $this->createDeleteForm($scriptQuestion);

        return $this->render('scriptquestion/show.html.twig', array(
            'scriptQuestion' => $scriptQuestion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing scriptQuestion entity.
     *
     * @Route("/{id}/edit", name="scriptquestion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ScriptQuestion $scriptQuestion)
    {
        $deleteForm = $this->createDeleteForm($scriptQuestion);
        $editForm = $this->createForm('AppliBundle\Form\ScriptQuestionType', $scriptQuestion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scriptquestion_edit', array('id' => $scriptQuestion->getId()));
        }

        return $this->render('scriptquestion/edit.html.twig', array(
            'scriptQuestion' => $scriptQuestion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a scriptQuestion entity.
     *
     * @Route("/{id}", name="scriptquestion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ScriptQuestion $scriptQuestion)
    {
        $form = $this->createDeleteForm($scriptQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scriptQuestion);
            $em->flush($scriptQuestion);
        }

        return $this->redirectToRoute('scriptquestion_index');
    }

    /**
     * Creates a form to delete a scriptQuestion entity.
     *
     * @param ScriptQuestion $scriptQuestion The scriptQuestion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ScriptQuestion $scriptQuestion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('scriptquestion_delete', array('id' => $scriptQuestion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
