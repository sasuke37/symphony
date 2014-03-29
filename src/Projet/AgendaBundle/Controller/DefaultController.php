<?php

namespace Projet\AgendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Projet\AgendaBundle\Entity\Login;
use Projet\AgendaBundle\Form\LoginType;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $personne = $em->getRepository("ProjetAgendaBundle:Login")->findAll();

        return $this->render('ProjetAgendaBundle:Default:index.html.twig', array('personne' => $personne));
    }

    public function suiteAction() 
    {
    	
    }

    public function inscriptionAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $a = new Login;
        $form = $this->createForm(new LoginType());
        $request = $this->getRequest();
        if($request->isMethod('POST')){
            // $form->bind($request);


            $a->setLogin($request->get('login'));
            $a->setPasswd($request->get('mdp'));



            $em->persist($a);
            $em->flush();

            return $this->redirect($this->generateUrl("projet_agenda_homepage"));
        }

        return $this->render('ProjetAgendaBundle:Default:inscription.html.twig', array());
    }
}