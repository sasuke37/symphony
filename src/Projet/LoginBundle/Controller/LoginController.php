<?php

namespace Projet\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

use Projet\LoginBundle\Entity\Login;

class LoginController extends Controller
{
    public function loginAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();

        if($request->isMethod('POST'))
        {

            $personne = $em->getRepository("ProjetLoginBundle:Login");
            $request = $this->getRequest();

            $res = $personne->findOneBy(array('login' => $request->get('login'), 'passwd' => $request->get('mdp')));

            if(!$res)
            { // Erreur
                return $this->render('ProjetLoginBundle:Login:login.html.twig', array('message' => "mot de passe ou login incorrect !!!"));
            }

            $session = new Session();
            $session->start();
            $session->set('user' , $res);

            return $this->redirect($this->generateUrl("projet_agenda_homepage"));
            // return $this->render('ProjetAgendaBundle:Agenda:suite.html.twig', array('user' => $cpt);
        }

        return $this->render('ProjetLoginBundle:Login:login.html.twig', array('message' => ""));
    }



    public function unloginAction()
    {
        $session = new Session();
        $session->start();

        $session->clear();

        return $this->redirect($this->generateUrl("projet_login_homepage"));
    }

    public function registerAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $login = new Login;

        $request = $this->getRequest();
        if($request->isMethod('POST')){

            $login->setLogin($request->get('login'));
            $login->setPasswd($request->get('mdp'));

            $em->persist($login);
            $em->flush();

            return $this->redirect($this->generateUrl("projet_login_homepage"));
        }

        return $this->render('ProjetLoginBundle:Register:register.html.twig');
    }
}
