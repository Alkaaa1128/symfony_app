<?php

namespace App\Controller;

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
               $acteur= $request->request->get('acteur');
               $genre_id= $request->request->get('genre');
               $affiche= $request->request->get('affiche');


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
            return $this->render('films/create.html.twig', [
                    'controller_name' => 'FilmsController',
                    'genres'           => $genres
                ]);
            
    }
}
