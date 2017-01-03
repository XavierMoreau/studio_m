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
     * From Projet_index - Button "Ecrire le script"
     * Creates a new script entity.
     *
     * @Route("/user={id}/projet={projet}/questions", name="script_index")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, User $user, Projet $projet)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()){

            // Création d'unee l'entité Script
            $script = new Script();

            // Attribution de l'Id du Projet au script
            $script->setProjet($projet->getId());

            $form = $this->createForm('AppliBundle\Form\ScriptType', $script);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $em->persist($script);
            $em->flush($script);

            // Attribution de l'Id du script au Projet
            $projet->setScript($script->getId());
            $em2 = $this->getDoctrine()->getManager();
            $em2->persist($projet);
            $em2->flush($projet);

            // Redirection vers les questions de base du script
            return $this->redirectToRoute('script_questions', array(
                'script' => $script->getId(),
                'id' => $user->getId(),
                'projet' => $projet->getId(),
            ));
   }

        // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }



    /**
     * From Projet_index - Button "Accéder au script"
     * Or from Script newAction
     * Ask base questions.
     *
     * @Route("/questions/user={id}/projet={projet}", name="script_questions")
     * @Method({"GET", "POST"})
     */
    public function questionsAction(Request $request, User $user, Projet $projet)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()){

            // On recherche toutes les questions à poser
            $em = $this->getDoctrine()->getManager();
            $questions = $em->getRepository('AppliBundle:ScriptQuestion')->findAll();


            // On vérifie s'il n'y a pas déjà des réponses pour ce script
            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppliBundle:ScriptReponse');
            $reponses = $repository->findByScript($projet->getScript());

            // Si on a des réponses existantes pour le scritp on renvoie vers formulaire Script Edit
            if ($reponses){
                return $this->render('script/edit.html.twig', array(
                    'user' => $user->getId(),
                    'projet' => $projet,
                    'questions' => $questions,
                    'reponses' => $reponses,

                ));
            }
            // Sinon on renvoie vers formulaire Script New
            else{
                return $this->render('script/new.html.twig', array(
                    'user' => $user->getId(),
                    'projet' => $projet,
                    'questions' => $questions,
                    ));
            }
        }

        // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }

    }


    /**
     * From questionsAction si pas de réponses existantes
     *
     * @Route("/reponsesnew/user={id}/projet={projet}/script={script}", name="script_reponses_new")
     * @Method({"GET", "POST"})
     */
    public function reponsesNewAction(Request $request, User $user, Projet $projet, Script $script)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()){

            // Pour chaque question/reponse
            foreach ($_POST as $key=>$reponse){

                // On récupère l'id de la question
                $questionId = $key;

                // Et on récupère l'entité question correspondante
                $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppliBundle:ScriptQuestion');
                $question = $repository->findOneById($questionId);

                // Création de la nouvelle entité script réponse
                $scriptReponse = new ScriptReponse();

                // Attribution du script, de la question et de la réponse
                $scriptReponse->setScript($script->getId());
                $scriptReponse->setQuestion($question);
                $scriptReponse->setReponse($reponse);

                // Envoi dans la BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($scriptReponse);
                $em->flush($script);

            }
            // Redirection vers l'écriture du script
            return $this->redirectToRoute('scriptecriture_new', array(
                'script' => $script->getId(),
                'id' => $user->getId(),
                'projet' => $projet->getId(),
            ));

        }

        // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }



    /**
     * From questionsAction si déjà des réponses existantes
     *
     * @Route("/reponsesedit/user={id}/projet={projet}/script={script}", name="script_reponses_edit")
     * @Method({"GET", "POST"})
     */
    public function reponsesEditAction(Request $request, User $user, Projet $projet, Script $script)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()){

            // Pour chaque question/reponse
            foreach ($_POST as $key=>$reponse){

                //On récupère l'entité ScriptReponse correspondante
                $scriptReponse = $this->getDoctrine()->getRepository('AppliBundle:ScriptReponse')->findOneById($key);

                // Et on modifie la réponse dans la BDD
                $scriptReponse->setReponse($reponse);
                $this->getDoctrine()->getEntityManager()->flush();

            }
            // Redirection vers l'écriture du script
            return $this->redirectToRoute('scriptecriture_new', array(
                'script' => $script->getId(),
                'id' => $user->getId(),
                'projet' => $projet->getId(),
            ));

        }

        // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else{
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }



//
//
//
//    /**
//     * Finds and displays a script entity.
//     *
//     * @Route("/user={id}", name="script_show")
//     * @Method("GET")
//     */
//    public function showAction(Script $script)
//    {
//        $deleteForm = $this->createDeleteForm($script);
//
//        return $this->render('script/show.html.twig', array(
//            'script' => $script,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
//
//    /**
//     * Displays a form to edit an existing script entity.
//     *
//     * @Route("/{id}/edit", name="script_edit")
//     * @Method({"GET", "POST"})
//     */
//    public function editAction(Request $request, Script $script)
//    {
//        $deleteForm = $this->createDeleteForm($script);
//        $editForm = $this->createForm('AppliBundle\Form\ScriptType', $script);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('script_edit', array('id' => $script->getId()));
//        }
//
//        return $this->render('script/edit.html.twig', array(
//            'script' => $script,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
//
//    /**
//     * Deletes a script entity.
//     *
//     * @Route("/{id}", name="script_delete")
//     * @Method("DELETE")
//     */
//    public function deleteAction(Request $request, Script $script)
//    {
//        $form = $this->createDeleteForm($script);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($script);
//            $em->flush($script);
//        }
//
//        return $this->redirectToRoute('script_index');
//    }
//
//    /**
//     * Creates a form to delete a script entity.
//     *
//     * @param Script $script The script entity
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm(Script $script)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('script_delete', array('id' => $script->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//        ;
//    }
}
