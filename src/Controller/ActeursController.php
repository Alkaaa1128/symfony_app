<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Entity\Film;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActeursController extends AbstractController
{
    /**
     * @Route("/acteurs", name="acteurs")
     */
    public function index(): Response
    {
        /*rajout  */
        $acteurs = $this->getDoctrine()
            ->getRepository(Acteur::class)
            ->findALL();
        /*rajout  */

        return $this->render('acteurs/index.html.twig', [
            'controller_name' => 'ActeursController',
            /*rajout  */
            'acteurs'           => $acteurs
            /*rajout  */
        ]);
    }

    /**
     * @Route("/acteurs/creation", name="acteurs_create")
     */
    
    
    public function create(Request $request): Response
    {
            if($request->isMethod("POST")){
               $nom= $request->request->get('nom');
               $prenom= $request->request->get('prenom');
               $dateNaissance= $request->request->get('date_naissance');
               $dateNaissance = new \DateTime($dateNaissance);
               $dateMort= $request->request->get('date_mort');
               $dateMort = new \DateTime($dateMort);

                $acteur = new Acteur;
                $acteur -> setNom($nom);
                $acteur -> setPrenom($prenom);
                $acteur -> setDateNaissance($dateNaissance);
                $acteur -> setDateMort($dateMort);

                $em = $this->getDoctrine()->getManager();
                $em->persist($acteur);
                $em->flush();


                return $this->redirectToRoute('acteurs');
            
            } 
            
            return $this->render('acteurs/create.html.twig', [
                    'controller_name' => 'ActeursController'

                ]);
            
    }
     /**
     * @Route("/acteurs/{id}/edition", name="acteurs_edit")
     */
    
         public function edit($id, Request $request): Response
    {
                $acteur = $this->getDoctrine()
                ->getRepository(Acteur::class)
                ->find($id);
             if($request->isMethod("POST")){
                $nom= $request->request->get('nom');
                $acteur -> setNom($nom);
                $prenom= $request->request->get('prenom');
                $acteur -> setPrenom($prenom);
                

                $em = $this->getDoctrine()->getManager();     
                $em->flush();


                return $this->redirectToRoute('acteurs');
            
            } 
            
            return $this->render('acteurs/edit.html.twig', [
                    'controller_name' => 'ActeursController',
                    'acteur' => $acteur
                ]);
            
    }

    /**
     * @Route("/acteurs/{id}/suppression", name="acteurs_delete")
     */
    
    public function delete($id, Request $request): Response
    {
                $acteur = $this->getDoctrine()
                ->getRepository(Acteur::class)
                ->find($id);
            

                $em = $this->getDoctrine()->getManager();  
                $em->remove($acteur);
                $em->flush();


                return $this->redirectToRoute('acteurs');
            
             
            
    }
}

