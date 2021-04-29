<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class ToDoController extends AbstractController
{
    /**
     * @Route("/ToDo",name="first")
     */
    public function indexAction(SessionInterface $session): Response
    {if(!$session->has('ToDo')){$ToDo=array('achat'=>'acheter clé usb','cours'=>'Finaliser mon cours','correction'=>'corriger mes examens');
    $session->set('ToDo',$ToDo);
    if(!$session->has('fromReset'))$this->addFlash('message',"Bienvenue");
    else{$session->remove('fromReset');}//pour éviter d'afficher bienvenue au reset
    }
        return $this->render('to_do/listeToDo.html.twig');
    }
    /**
     * @Route("/ToDo/add/{cle}/{valeur}")
     */
    public function addToDo($cle,$valeur,SessionInterface $session){
        if(!$session->has('ToDo'))
            {$this->addFlash('error',"Le tableau n'est pas encore initialisé");}
        else {$s=$session->get('ToDo');
            if(isset($s[$cle])){$this->addFlash('error',"Cette clé existe");}
            else{//$session->get('ToDo')[$cle]=$valeur; ne marche pas il faut un set
                $s[$cle]=$valeur;
                $session->set('ToDo',$s);
                $this->addFlash('message',"element ajouté");

            }

        }
        return $this->redirectToRoute('first');
    }
    /**
     * @Route("/ToDo/delete/{cle}")
     */
    public function deleteToDo($cle,SessionInterface $session){
        if(!$session->has('ToDo'))
        {$this->addFlash('error',"Le tableau n'est pas encore initialisé");}
        else {$s=$session->get('ToDo');
            if(!isset($s[$cle])){$this->addFlash('error',"Cette clé n'existe pas");}
            else{unset($s[$cle]);
                $session->set('ToDo',$s);
                $this->addFlash('message',"element supprimé");

            }

        }
        return $this->redirectToRoute('first');
    }
    /**
     * @Route("/ToDo/update/{cle}/{valeur}")
     */
    public function updateToDo($cle,$valeur,SessionInterface $session){
        if(!$session->has('ToDo'))
        {$this->addFlash('error',"Le tableau n'est pas encore initialisé");}
        else {$s=$session->get('ToDo');
            if(!isset($s[$cle])){$this->addFlash('error',"Cette clé n'existe pas");}
            else{//$session->get('ToDo')[$cle]=$valeur; ne marche pas il faut un set
                $s[$cle]=$valeur;
                $session->set('ToDo',$s);
                $this->addFlash('message',"element mis à jour");

            }

        }
        return $this->redirectToRoute('first');
    }
    /**
     * @Route("/ToDo/reset")
     */
    public function resetToDo(SessionInterface $session){
        if(!$session->has('ToDo'))
        {$this->addFlash('error',"Le tableau n'est pas encore initialisé");}
        else {//session_unset();
            $session->remove('ToDo');
            $session->set('fromReset','true');
            $this->addFlash('success',"Reset successfully");
        }
        return $this->redirectToRoute('first');
    }
}
