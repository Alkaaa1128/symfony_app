<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenresController extends AbstractController
{
    /**
     * @Route("/genre", name="genre")
     */
    public function index(): Response
    {
        $genres = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->findALL();
        return $this->render('genres/index.html.twig', [
            'controller_name' => 'GenresController',
            'genres' => $genres
        ]);
    }
        /**
     * @Route("/genres/creation", name="films_create")
     */
    
    
     public function create(Request $request): Response
    {
            if($request->isMethod("POST")){
               $titre= $request->request->get('titre');
               $resume= $request->request->get('resume');
               $annee_sortie= $request->request->get('annee_sortie');
               $acteur= $request->request->get('acteur');
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
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($film);
                $em->flush();


                return $this->redirectToRoute('films');
            

            } 
            $genres = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->findALL();
            
            return $this->render('genres/create.html.twig', [
                    'controller_name' => 'FilmsController',
                    'genres'           => $genres
                ]);
            
    }
}
