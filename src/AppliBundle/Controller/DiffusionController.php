<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\Diffusion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Diffusion controller.
 *
 * @Route("diffusion")
 */
class DiffusionController extends Controller
{
    /**
     * Lists all diffusion entities.
     *
     * @Route("/", name="diffusion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $diffusions = $em->getRepository('AppliBundle:Diffusion')->findAll();

        return $this->render('diffusion/index.html.twig', array(
            'diffusions' => $diffusions,
        ));
    }

    /**
     * Creates a new diffusion entity.
     *
     * @Route("/new", name="diffusion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $diffusion = new Diffusion();
        $form = $this->createForm('AppliBundle\Form\DiffusionType', $diffusion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($diffusion);
            $em->flush($diffusion);

            return $this->redirectToRoute('diffusion_index');
        }

        return $this->render('diffusion/new.html.twig', array(
            'diffusion' => $diffusion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a diffusion entity.
     *
     * @Route("/{id}", name="diffusion_show")
     * @Method("GET")
     */
    public function showAction(Diffusion $diffusion)
    {
        $deleteForm = $this->createDeleteForm($diffusion);

        return $this->render('diffusion/show.html.twig', array(
            'diffusion' => $diffusion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing diffusion entity.
     *
     * @Route("/{id}/edit", name="diffusion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Diffusion $diffusion)
    {
        $deleteForm = $this->createDeleteForm($diffusion);
        $editForm = $this->createForm('AppliBundle\Form\DiffusionType', $diffusion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('diffusion_index');
        }

        return $this->render('diffusion/edit.html.twig', array(
            'diffusion' => $diffusion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a diffusion entity.
     *
     * @Route("/delete/{id}", name="diffusion_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(Diffusion $diffusion)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($diffusion);
            $em->flush($diffusion);


        return $this->redirectToRoute('diffusion_index');
    }

    /**
     * Creates a form to delete a diffusion entity.
     *
     * @param Diffusion $diffusion The diffusion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Diffusion $diffusion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('diffusion_delete', array('id' => $diffusion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
