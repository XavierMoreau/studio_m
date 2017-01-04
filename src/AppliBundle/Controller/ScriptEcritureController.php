<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\Script;
use AppliBundle\Entity\Projet;
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
            $ecriture = [];
            foreach ($reponses as $key=>$value) {
                $repository = $this->getDoctrine()->getManager()->getRepository('AppliBundle:ScriptEcriture');
                $ecriture[$key] = $repository->findByScriptReponse($value);

            }
            return $this->render('scriptecriture/new.html.twig', array(
                'ecritures' => $ecriture,
                'reponses' => $reponses,
                'questions' => $questions,
                'script' => $script->getId(),
                'id' => $user->getId(),
                'projet' => $projet->getId(),
            ));

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

            // Et on récupère l'entité reponse correspondante
            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppliBundle:ScriptReponse');
            $reponse = $repository->findOneById($_POST[0]);


            // Création de la nouvelle entité script réponse
            $scriptEcriture = new ScriptEcriture();

            // Attribution du script, de la question et de la réponse à l'entité ScriptReponse
            $scriptEcriture->setScriptReponse($reponse);
            $scriptEcriture->setVoixoff($_POST[1]);
            $scriptEcriture->setDescription($_POST[2]);
            $scriptEcriture->setTempsForceMin($_POST[3]);
            $scriptEcriture->setTempsForceSec($_POST[4]);


            // Envoi dans la BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($scriptEcriture);
            $em->flush($script);


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

    /**
     * Finds and displays a scriptEcriture entity.
     *
     * @Route("/{id}", name="scriptecriture_show")
     * @Method("GET")
     */
    public function showAction(ScriptEcriture $scriptEcriture)
    {
        $deleteForm = $this->createDeleteForm($scriptEcriture);

        return $this->render('scriptecriture/show.html.twig', array(
            'scriptEcriture' => $scriptEcriture,
            'delete_form' => $deleteForm->createView(),
        ));
    }

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

            // Et on modifie la réponse dans la BDD
            $ecriture->setVoixoff($_POST[1]);
            $ecriture->setDescription($_POST[2]);
            $ecriture->setTempsForceMin($_POST[3]);
            $ecriture->setTempsForceSec($_POST[4]);


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


    /**
     * Deletes a scriptEcriture entity.
     *
     * @Route("/{id}", name="scriptecriture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ScriptEcriture $scriptEcriture)
    {
        $form = $this->createDeleteForm($scriptEcriture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scriptEcriture);
            $em->flush($scriptEcriture);
        }

        return $this->redirectToRoute('scriptecriture_index');
    }

    /**
     * Creates a form to delete a scriptEcriture entity.
     *
     * @param ScriptEcriture $scriptEcriture The scriptEcriture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ScriptEcriture $scriptEcriture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('scriptecriture_delete', array('id' => $scriptEcriture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
