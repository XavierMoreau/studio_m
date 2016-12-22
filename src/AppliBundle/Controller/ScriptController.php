<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\Script;
use AppliBundle\Entity\Projet;
use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Script controller.
 *
 * @Route("script")
 */
class ScriptController extends Controller
{
    /**
     * Lists all script entities.
     *
     * @Route("//user={id}/projet={projet}", name="script_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request, User $user, Projet $projet)
    {

        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository('AppliBundle:ScriptQuestion')->findAll();



        return $this->render('script/index.html.twig', array(
            'user' => $user->getId(),
            'projet' => $projet->getId(),
            'questions' => $questions
        ));
    }


    /**
     * Creates a new script entity.
     *
     * @Route("/user={id}/projet={projet}/questions", name="script_questions")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, User $user, Projet $projet)
    {
        if ($user === $this->getUser()){
        $script = new Script();
        $script->setProjet($projet->getId());



            $form = $this->createForm('AppliBundle\Form\ScriptType', $script);
            $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $em->persist($script);
            $em->flush($script);




            return $this->redirectToRoute('scriptreponse_new', array(
                'script' => $script->getId(),
                'id' => $user->getId(),
                'projet' => $projet->getId(),
                ));



        }
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }

    /**
     * Finds and displays a script entity.
     *
     * @Route("/user={id}", name="script_show")
     * @Method("GET")
     */
    public function showAction(Script $script)
    {
        $deleteForm = $this->createDeleteForm($script);

        return $this->render('script/show.html.twig', array(
            'script' => $script,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing script entity.
     *
     * @Route("/{id}/edit", name="script_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Script $script)
    {
        $deleteForm = $this->createDeleteForm($script);
        $editForm = $this->createForm('AppliBundle\Form\ScriptType', $script);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('script_edit', array('id' => $script->getId()));
        }

        return $this->render('script/edit.html.twig', array(
            'script' => $script,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a script entity.
     *
     * @Route("/{id}", name="script_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Script $script)
    {
        $form = $this->createDeleteForm($script);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($script);
            $em->flush($script);
        }

        return $this->redirectToRoute('script_index');
    }

    /**
     * Creates a form to delete a script entity.
     *
     * @param Script $script The script entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Script $script)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('script_delete', array('id' => $script->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}