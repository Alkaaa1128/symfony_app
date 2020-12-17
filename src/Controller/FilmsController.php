<?php

namespace App\Controller;

use App\Entity\Film;
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

                $film =  new Film;
                $film->setTitre($titre);
                $film->setResume($resume);
                $film->setAnneeSortie($annee_sortie);       
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($film);
                $em->flush();

                return $this->redirectToRoute('films');
            

            } 
            return $this->render('films/create.html.twig', [
                    'controller_name' => 'FilmsController',
                ]);
            
    }
}
