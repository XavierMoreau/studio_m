<?php

namespace AppliBundle\Controller;

use AppliBundle\Entity\Script;
use AppliBundle\Entity\Projet;
use AppliBundle\Entity\ScriptEcriture;
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
     *
     * @Route("/orientation/user={id}/projet={projet}/script={script}", name="script_orientation")
     * @Method({"GET", "POST"})
     */
    public function orientationAction(Request $request, User $user, Projet $projet, Script $script)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()) {


            return $this->render('script/orientation.html.twig', array(
                'user' => $user,
                'projet' => $projet,
                'script' => $script

            ));
        } // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else {
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }


    /**
     * From Script Orientation - Button "Ecrire la voix off"
     *
     * @Route("/voixoff/user={id}/projet={projet}/script={script}", name="script_voixoff")
     * @Method({"GET", "POST"})
     */
    public function voixoffAction(Request $request, User $user, Projet $projet, Script $script)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()) {

            // On recherche toutes les questions à poser
            if ($script->getVoixoffGlobal()) {
                $count = str_word_count($script->getVoixoffGlobal(), 0);

                return $this->render('script/voixoff.html.twig', array(
                    'user' => $user,
                    'projet' => $projet,
                    'script' => $script,
                    'count' => $count
                ));

            } else {
                $count = 0;

                return $this->render('script/voixoff.html.twig', array(
                    'user' => $user,
                    'projet' => $projet,
                    'script' => $script,
                    'count' => $count
                ));
            }

        } // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else {
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }


    /**
     * From Projet_index - Button "Ecrire le script"
     *
     * @Route("/voixoffedit/user={id}/projet={projet}/script={script}", name="script_voixoff_edit")
     * @Method({"GET", "POST"})
     */
    public function voixoffEditAction(Request $request, User $user, Projet $projet, Script $script)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()) {

            $count = str_word_count($_POST["voixoff"], 0);

            $script->setVoixoffGlobal($_POST["voixoff"]);
            $this->getDoctrine()->getEntityManager()->flush();

            // Redirection vers l'écriture du script
            return $this->redirectToRoute('script_voixoff', array(
                'script' => $script->getId(),
                'id' => $user->getId(),
                'projet' => $projet->getId(),
                'count' => $count
            ));
        } // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else {
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }


    /**
     * From Projet_index - Button "Accéder au script"
     * Or from Script newAction
     * Ask base questions.
     *
     * @Route("/questions/user={id}/projet={projet}/script={script}", name="script_questions")
     * @Method({"GET", "POST"})
     */
    public function questionsAction(Request $request, User $user, Projet $projet, Script $script)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()) {

            // On recherche toutes les questions à poser
            $em = $this->getDoctrine()->getManager();
            $questions = $em->getRepository('AppliBundle:ScriptQuestion')->findAll();


            // On vérifie s'il n'y a pas déjà des réponses pour ce script
            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppliBundle:ScriptReponse');
            $reponses = $repository->findByScript($projet->getScript());

            // Si on a des réponses existantes pour le script on renvoie vers formulaire Script Edit
            if ($reponses) {
                return $this->render('script/edit.html.twig', array(
                    'user' => $user,
                    'projet' => $projet,
                    'questions' => $questions,
                    'reponses' => $reponses,
                    'script' => $script
                ));
            } // Sinon on créée les entités Réponses et Ecritures
            else {

                // Pour chaque question on crée une entité scriptréponse et une entité scriptEcriture
                foreach ($questions as $key => $question) {

                    // Création de la nouvelle entité script réponse
                    $scriptReponse = new ScriptReponse();


                    // Attribution du script, de la question et de la réponse à l'entité ScriptReponse
                    $scriptReponse->setScript($script);
                    $scriptReponse->setQuestion($question);


                    // Envoi dans la BDD
                    $em = $this->getDoctrine()->getManager();
                    $em->persist( $scriptReponse);
                    $em->flush($scriptReponse);
                }

                // On récupère les réponses justes créées pour ce script
                $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppliBundle:ScriptReponse');
                $reponses = $repository->findByScript($projet->getScript());


                return $this->render('script/edit.html.twig', array(
                    'user' => $user,
                    'projet' => $projet,
                    'questions' => $questions,
                    'reponses' => $reponses,
                    'script' => $script
                ));
            }
        } // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else {
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
        if ($user === $this->getUser()) {


            // Pour chaque question/reponse
            foreach ($_POST as $key => $reponse) {

                //On récupère l'entité ScriptReponse correspondante
                $scriptReponse = $this->getDoctrine()->getRepository('AppliBundle:ScriptReponse')->findOneById($key);

                // Et on modifie la réponse dans la BDD
                $scriptReponse->setReponse($reponse);
                $this->getDoctrine()->getEntityManager()->flush();

            }
            // Redirection vers l'écriture du script
            return $this->redirectToRoute('script_questions', array(
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
     * Finds and displays a script entity.
     *
     * @Route("/valid/user={id}/projet={projet}/script={script}", name="script_valid")
     * @Method("GET")
     */
    public function validAction(User $user, Projet $projet, Script $script)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()) {

            // Récupération des réponses
            $repositoryR = $this->getDoctrine()->getManager()->getRepository('AppliBundle:ScriptReponse');
            $reponses = $repositoryR->findByScript($script);

            return $this->render('script/show.html.twig', array(
                'reponses' => $reponses,
                'script' => $script,
                'user' => $user,
                'projet' => $projet,
            ));

        } // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else {
            return $this->render('AppliBundle:Default:unauthorized.html.twig');
        }
    }


    /**
     * From Projet_index - Button "Ecrire le script"
     *
     * @Route("/print/user={id}/projet={projet}/script={script}", name="script_print")
     * @Method({"GET", "POST"})
     */
    public function printAction(Request $request, User $user, Projet $projet, Script $script)
    {
        // Controle de l'utilisateur
        if ($user === $this->getUser()) {

            // Récupération des réponses
            $repositoryR = $this->getDoctrine()->getManager()->getRepository('AppliBundle:ScriptReponse');
            $reponses = $repositoryR->findByScript($script);

//            // Récupération des questions
//            $repositoryQ = $this->getDoctrine()->getManager()->getRepository('AppliBundle:ScriptQuestion');
//            $questions = $repositoryQ->findAll();

            // Récupération des écritures
            $repository = $this->getDoctrine()->getManager()->getRepository('AppliBundle:ScriptEcriture');
            $ecriture = $repository->findByScriptReponse($script);

            // s'il y a des données on les renvoie dans le formulaire

            return $this->render('scriptecriture/edit.html.twig', array(
                'ecritures' => $ecriture,
                'reponses' => $reponses,
//                'questions' => $questions,
                'script' => $script,
                'id' => $user,
                'projet' => $projet,
            ));
        }
            // Si mauvais Utilisateur on renvoie vers page Unauthorized
        else{
                return $this->render('AppliBundle:Default:unauthorized.html.twig');
            }



    }
}
