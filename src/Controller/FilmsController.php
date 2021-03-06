<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Entity\Film;
use App\Entity\Genre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmsController extends AbstractController
{
    /**
     * @Route("/films", name="films")
     */
    public function index(): Response
    {
        $films = $this->getDoctrine()
            ->getRepository(Film::class)
            ->findALL();

        return $this->render('films/index.html.twig', [
            'controller_name' => 'FilmsController',
            'films'           => $films
        ]);
    }

     /**
     * @Route("/films/creation", name="films_create")
     */
    public function create(Request $request): Response
    {
            if($request->isMethod("POST")){
               $titre= $request->request->get('titre');
               $resume= $request->request->get('resume');
               $annee_sortie= $request->request->get('annee_sortie');
               $acteurs= $request->request->get('acteur');
               $affiche= $request->request->get('affiche');
               $genre_id= $request->request->get('genre');

               $genre = $this->getDoctrine()
               ->getRepository(Genre::class)
               ->find($genre_id);

               

                $film =  new Film;
                $film->setTitre($titre);
                $film->setResume($resume);
                $film->setAnneeSortie($annee_sortie);  
                //$film->setActeur($acteur);
                $film->setGenre($genre);
                $film->setAffiche($affiche);   
                
                foreach ($acteurs as $id){
                    $acteur = $this->getDoctrine()
                    ->getRepository(Acteur::class)
                    ->find($id);
                    $film -> addActeur($acteur);

                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($film);
                $em->flush();


                return $this->redirectToRoute('films');
            

            } 
            $genres = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->findALL();

            $acteurs = $this->getDoctrine()
            ->getRepository(Acteur::class)
            ->findALL();
            
            return $this->render('films/create.html.twig', [
                    'controller_name' => 'FilmsController',
                    'genres'           => $genres,
                    'acteurs' => $acteurs,
                ]);
            
    }

     /**
     * @Route("/films/{id}/edition", name="films_edit")
     */
    
    public function edit($id, Request $request): Response
    {
                $film = $this->getDoctrine()
                ->getRepository(Film::class)
                ->find($id);

                $acteurs = $this->getDoctrine()
                ->getRepository(Acteur::class)
                ->findALL();

                
                $genres = $this->getDoctrine()
                ->getRepository(Genre::class)
                ->findALL();

            
             if($request->isMethod("POST")){
                $titre= $request->request->get('titre');
                $film -> setTitre($titre);
                $acteurs = $request->request->get('acteur');

                $genres = $request->request->get('genre');

                /*

                $film ->setGenre($genres);*/

                $film->getActeurs()->clear();
                

                foreach ($acteurs as $id){
                    $acteur = $this->getDoctrine()
                    ->getRepository(Acteur::class)
                    ->find($id);
                    $film -> addActeur($acteur);

                }

                /*foreach ($genres as $id){
                    $genre = $this->getDoctrine()
                    ->getRepository(Genre::class)
                    ->find($id);
                    $film -> setGenre($genre);

                }
                
                $film->getGenre()->clear();*/

                $em = $this->getDoctrine()->getManager();     
                $em->flush();

                return $this->redirectToRoute('films');
            
            } 
            
            return $this->render('films/edit.html.twig', [
                    'controller_name' => 'FilmsController',
                    'film' => $film,
                    'acteurs' => $acteurs,
                    'genres' => $genres,
                ]);
            
    }






    /**
     * @Route("/films/{id}/suppression", name="films_delete")
     */
    
    public function delete($id, Request $request): Response
    {
                $film = $this->getDoctrine()
                ->getRepository(Film::class)
                ->find($id);
            

                $em = $this->getDoctrine()->getManager();  
                $em->remove($film);
                $em->flush();


                return $this->redirectToRoute('films');
            
             
            
    }




}
