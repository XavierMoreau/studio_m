<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\Script;
use AppliBundle\Entity\Projet;
use AppliBundle\Entity\ScriptReponse;
use UserBundle\Entity\User;
use AppliBundle\Entity\ScriptEcriture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Scriptecriture controller.
 *
 * @Route("scriptecriture")
 */
class ScriptEcritureController extends Controller
{
    /**
     * Lists all scriptEcriture entities.
     *
     * @Route("/user={id}/projet={projet}/script={script}", name="scriptecriture_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, Script $script, Projet $projet, User $user)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()) {

            // Récupération des réponses
            $repositoryR = $this->getDoctrine()->getManager()->getRepository('AppliBundle:ScriptReponse');
            $reponses = $repositoryR->findByScript($script);

            // Récupération des questions
            $repositoryQ = $this->getDoctrine()->getManager()->getRepository('AppliBundle:ScriptQuestion');
            $questions = $repositoryQ->findAll();

            // Vérification si données déjà saisies
            $repository = $this->getDoctrine()->getManager()->getRepository('AppliBundle:ScriptEcriture');
            $ecriture = $repository->findByScript($script);

            // s'il y a des données on les renvoie dans le formulaire
            if ($ecriture) {
                return $this->render('scriptecriture/edit.html.twig', array(
                    'ecritures' => $ecriture,
                    'reponses' => $reponses,
                    'questions' => $questions,
                    'script' => $script,
                    'id' => $user,
                    'projet' => $projet,
                ));
            // s'il n'y a pas de données écritures, on en créé une
            }else{

                    $scriptEcriture = new ScriptEcriture();
                    $scriptEcriture->setScript($script);
                    $scriptEcriture->setCount('0');

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($scriptEcriture);
                    $em->flush($scriptEcriture);


                $repository = $this->getDoctrine()->getManager()->getRepository('AppliBundle:ScriptEcriture');
                $ecriture = $repository->findByScript($script);

                // et on la renvoie vide dans le formulaire
                return $this->render('scriptecriture/edit.html.twig', array(
                    'ecritures' => $ecriture,
                    'reponses' => $reponses,
                    'questions' => $questions,
                    'script' => $script,
                    'id' => $user,
                    'projet' => $projet,
                ));


            }

        } // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else {
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }

    /**
     * Creates a new scriptEcriture entity.
     *
     * @Route("/new/user={id}/projet={projet}/script={script}", name="scriptecriture_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Script $script, Projet $projet, User $user)

    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()) {

            // Création de la nouvelle entité script réponse
            $scriptEcriture = new ScriptEcriture();

            // Attribution du script
            $scriptEcriture->setScript($script);

            // Envoi dans la BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($scriptEcriture);
            $em->flush($scriptEcriture);


            return $this->redirectToRoute('scriptecriture_index', array(
                'script' => $script->getId(),
                'id' => $user->getId(),
                'projet' => $projet->getId(),


            ));



        } // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else {
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }

//    /**
//     * Finds and displays a scriptEcriture entity.
//     *
//     * @Route("/{id}", name="scriptecriture_show")
//     * @Method("GET")
//     */
//    public function showAction(ScriptEcriture $scriptEcriture)
//    {
//        $deleteForm = $this->createDeleteForm($scriptEcriture);
//
//        return $this->render('scriptecriture/show.html.twig', array(
//            'scriptEcriture' => $scriptEcriture,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing scriptEcriture entity.
     *
     * @Route("/edit/user={id}/projet={projet}/script={script}/ecriture={ecriture}", name="scriptecriture_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ScriptEcriture $ecriture, User $user, Projet $projet, Script $script)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()) {

            $count = str_word_count($_POST[1], 0);

            // Et on modifie la réponse dans la BDD
            $ecriture->setVoixoff($_POST[1]);
            $ecriture->setDescription($_POST[2]);
            $ecriture->setTempsForceMin($_POST[3]);
            $ecriture->setTempsForceSec($_POST[4]);
            $ecriture->setCount($count);


            // Envoi dans la BDD

            $this->getDoctrine()->getEntityManager()->flush();


            // Redirection vers l'écriture du script
            return $this->redirectToRoute('scriptecriture_index', array(
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
//    /**
//     * Deletes a scriptEcriture entity.
//     *
//     * @Route("/{id}", name="scriptecriture_delete")
//     * @Method("DELETE")
//     */
//    public function deleteAction(Request $request, ScriptEcriture $scriptEcriture)
//    {
//        $form = $this->createDeleteForm($scriptEcriture);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($scriptEcriture);
//            $em->flush($scriptEcriture);
//        }
//
//        return $this->redirectToRoute('scriptecriture_index');
//    }
//
//    /**
//     * Creates a form to delete a scriptEcriture entity.
//     *
//     * @param ScriptEcriture $scriptEcriture The scriptEcriture entity
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm(ScriptEcriture $scriptEcriture)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('scriptecriture_delete', array('id' => $scriptEcriture->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//        ;
//    }
}
