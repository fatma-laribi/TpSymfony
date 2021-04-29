<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    /**
     * @Route("/todo", name="todo")
     */
    public function indexAction(SessionInterface $session)
    {
        if (! $session->has('todos')) {
            $todos=[];
            $session->set('todos',$todos);
            $this->addFlash('info','Bienvenue dans votre platforme des gestion des ToDos');
        }
        return $this->render('to_do/listeToDo.html.twig');

    }

    /**
     * @Route("todo/add/{name}/{content?rien faire}",name="addtodo")
     */

    public function addToDo($name,$content,SessionInterface $session){
        //verifier que la session contient un tableau de todos
        if(! $session->has('todos')){
            //ko=>message erreur+redirection
            $this->addFlash('error',"La liste des Todos n'est pas encore initialisée");
        }else{
            //ok
            //je verifie si le todo existe
            $todos=$session->get('todos');
            if(isset($todos[$name])){
                //ko=>message erreur+redirection
                $this->addFlash('error',"Le todo $name existe deja");
            }
            else{
                //ok=>j'ajoute et je redirige avec message succès
                $todos[$name] = $content;
                $session->set('todos',$todos);
                $this->addFlash('success',"Le todo $name a été ajouté avec succès");
            }
        }
        return $this->redirectToRoute("todo");
    }

    /**
     * @Route("todo/supp/{name}",name="supptodo")
     */

    public function suppToDo($name,SessionInterface $session){
        //verifier que la session contient un tableau de todos
        if(! $session->has('todos')){
            //ko=>message erreur+redirection
            $this->addFlash('error',"La liste des Todos n'est pas encore initialisée");
        }else{
            //ok
            //je verifie si le todo existe
            $todos=$session->get('todos');
            if(! isset($todos[$name])){
                //ko=>message erreur+redirection
                $this->addFlash('error',"Le todo $name n'existe pas");
            }
            else{
                //ok=>j'ajoute et je redirige avec message succès
                unset($todos[$name]);
                $session->set('todos',$todos);
                $this->addFlash('success',"Le todo $name a été supprimé avec succès");
            }
        }
        return $this->redirectToRoute("todo");
    }

    /**
     * @Route("todo/modif/{name}/{content?rien faire}",name="modiftodo")
     */

    public function modifToDo($name,$content,SessionInterface $session){
        //verifier que la session contient un tableau de todos
        if(! $session->has('todos')){
            //ko=>message erreur+redirection
            $this->addFlash('error',"La liste des Todos n'est pas encore initialisée");
        }else{
            //ok
            //je verifie si le todo existe
            $todos=$session->get('todos');
            if(! isset($todos[$name])){
                //ko=>message erreur+redirection
                $this->addFlash('error',"Le todo $name : $content n'existe pas");
            }
            else{
                //ok=>j'ajoute et je redirige avec message succès
                $todos[$name]=$content;
                $session->set('todos',$todos);
                $this->addFlash('success',"Le todo $name a été modifié avec succès");
            }
        }
        return $this->redirectToRoute("todo");
    }

    /**
     * @Route("todo/reset",name="resettodo")
     */

    public function resetToDo(SessionInterface $session){
        //verifier que la session contient un tableau de todos
        if(! $session->has('todos')){
            //ko=>message erreur+redirection
            $this->addFlash('error',"La liste des Todos n'est pas encore initialisée");
        }else{
            //ok
            $session->remove('todos');
            $this->addFlash('success',"La liste des Todos a été réinitialisée");
        }
        return $this->redirectToRoute("todo");
    }
}