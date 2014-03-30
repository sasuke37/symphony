<?php

namespace Projet\AgendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DateTime;


use Projet\AgendaBundle\Entity\Activity;
use Projet\AgendaBundle\Entity\Planning;


class AgendaController extends Controller
{

    public function agendaAction()
    {
        $session = new Session();
        $em = $this->getDoctrine()->getEntityManager();
        $session->start();

        if($session->has('user') == false) {
            return $this->redirect($this->generateUrl("projet_login_homepage"));
        }

        $user = $session->get('user');
        $today = new \DateTime("now");
        $today->format("d-m-Y H:i");
        
        $res = $em->getRepository("ProjetAgendaBundle:Planning")->findAll();

        // $interval = new \DateInterval('P1D');
        $demain = clone $today;
        $demain->modify("+ 1 days");

        $cpt=0;
        $tab = array();
        $cptaux = 0;
        foreach ($res as $i) {

            if($i->getDate() >= $today && $i->getDate() <= $demain && $i->getIduser() == $user->getId() ){
                $tab[$cpt]['id'] = $i->getId();
                $tab[$cpt]['act'] = $em->getRepository("ProjetAgendaBundle:Activity")->find($i->getIdAct())->getNom();
                $tab[$cpt]['date'] = $i->getDate();
                $cpt += 1;

            }

        }



        return $this->render('ProjetAgendaBundle:Agenda:suite.html.twig', array('user' => $user, 'Activity' => $tab , 'Activ' => $em->getRepository("ProjetAgendaBundle:Activity")->findAll()));
        
    }

    public function ajouterAction()
    {
        $session = new Session();
        $session->start();

        if($session->has('user') == false) {
            return $this->redirect($this->generateUrl("projet_login_homepage"));
        }

        $user = $session->get('user');

        $request = $this->getRequest();
        if($request->isMethod('POST'))
        {
            $planning = new Planning;

            $date = $request->get('date');
            $heure = $request->get('heure');
            $minute = $request->get('minute');
            $type = $request->get('type');

            $date = $date . " " .$heure. ":" . $minute;
            $date = date_create($date);
            $date->format("d-m-Y H:i");
            $planning->setDate($date);
            $planning->setIdact($type);
            $planning->setIduser($user->getId());

            $em = $this->getDoctrine()->getManager();

            $em->persist($planning);
            $em->flush();
        }

        return $this->redirect($this->generateUrl("projet_agenda_homepage"));
    }

    public function supprimerAction()
    {
        $session = new Session();
        $session->start();

        if($session->has('user') == false) {
            return $this->redirect($this->generateUrl("projet_login_homepage"));
        }

        $user = $session->get('user');

        $request = $this->getRequest();
        if($request->isMethod('POST'))  
        {
            $em = $this->getDoctrine()->getManager();
            $id = $request->get('id');
            $entt = $em->getRepository('ProjetAgendaBundle:Planning')->findoneBy(array('id' => $id));

            if($entt)
            {
                $em->remove($entt);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl("projet_agenda_homepage"));
    }
}
