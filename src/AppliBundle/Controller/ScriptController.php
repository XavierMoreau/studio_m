<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\Script;
use AppliBundle\Entity\Projet;
use AppliBundle\Entity\ScriptQuestion;
use AppliBundle\Entity\ScriptReponse;
use AppliBundle\Form\ScriptReponseType;
use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Script controller.
 *
 * @Route("script")
 */
class ScriptController extends Controller
{

    /**
     * Creates a new script entity.
     *
     * @Route("/user={id}/projet={projet}/questions", name="script_index")
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


            $projet->setScript($script->getId());
            $em2 = $this->getDoctrine()->getManager();
            $em2->persist($projet);
            $em2->flush($projet);



            return $this->redirectToRoute('script_questions', array(
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
     * Ask base questions.
     *
     * @Route("/questions/user={id}/projet={projet}", name="script_questions")
     * @Method({"GET", "POST"})
     */
    public function questionsAction(Request $request, User $user, Projet $projet)
    {
        // On recherche toutes les questions à poser
        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository('AppliBundle:ScriptQuestion')->findAll();


        // On vérifie s'il n'y a pas déjà des réponses pour ce script
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppliBundle:ScriptReponse');
        $reponses = $repository->findByScript($projet->getScript());

        if ($reponses){
            return $this->render('script/edit.html.twig', array(

                'user' => $user->getId(),
                'projet' => $projet,
                'questions' => $questions,
                'reponses' => $reponses,

            ));
        }
        // On envoie à la page script_index, formulaire des questions de base
        else{
            return $this->render('script/index.html.twig', array(

                'user' => $user->getId(),
                'projet' => $projet,
                'questions' => $questions,


            ));
        }

    }


    /**
     * Flush answers to questions in DB.
     *
     * @Route("/reponsesnew/user={id}/projet={projet}/script={script}", name="script_reponses_new")
     * @Method({"GET", "POST"})
     */
    public function reponsesNewAction(Request $request, User $user, Projet $projet, Script $script)
    {

        foreach ($_POST as $key=>$reponse){

            $questionId = str_replace("reponse", "", $key);

            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppliBundle:ScriptQuestion');

            $question = $repository->findOneById($questionId);

            $scriptReponse = new ScriptReponse();
            $scriptReponse->setScript($script->getId());
            $scriptReponse->setQuestion($question);
            $scriptReponse->setReponse($reponse);

            $em = $this->getDoctrine()->getManager();
            $em->persist($scriptReponse);
            $em->flush($script);

        }
        return $this->redirectToRoute('scriptecriture_new', array(
            'script' => $script->getId(),
            'id' => $user->getId(),
            'projet' => $projet->getId(),
        ));
    }



    /**
     * Flush modificated answers to questions in DB.
     *
     * @Route("/reponsesedit/user={id}/projet={projet}/script={script}", name="script_reponses_edit")
     * @Method({"GET", "POST"})
     */
    public function reponsesEditAction(Request $request, User $user, Projet $projet, Script $script)
    {


        foreach ($_POST as $key=>$reponse){

            $scriptReponse = $this->getDoctrine()->getRepository('AppliBundle:ScriptReponse')->findOneById($key);
            $scriptReponse->setReponse($reponse);
            $this->getDoctrine()->getEntityManager()->flush();

        }
        return $this->redirectToRoute('scriptecriture_new', array(
            'script' => $script->getId(),
            'id' => $user->getId(),
            'projet' => $projet->getId(),
        ));
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
