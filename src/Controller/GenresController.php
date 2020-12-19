<?php

namespace App\Controller;

use App\Entity\Genre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenresController extends AbstractController
{
    /**
     * @Route("/genres", name="genres")
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
     * @Route("/genres/creation", name="genres_create")
     */
    
    
     public function create(Request $request): Response
    {
            if($request->isMethod("POST")){
               $name= $request->request->get('name');
               
                $genre = new Genre;
                $genre -> setName($name);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($genre);
                $em->flush();


                return $this->redirectToRoute('genres');
            
            } 
            
            return $this->render('genres/create.html.twig', [
                    'controller_name' => 'GenresController'
                ]);
            
    }
     /**
     * @Route("/genres/{id}/edition", name="genres_edit")
     */
    
         public function edit($id, Request $request): Response
    {
                $genre = $this->getDoctrine()
                ->getRepository(Genre::class)
                ->find($id);
             if($request->isMethod("POST")){
                $name= $request->request->get('name');
                $genre -> setName($name);

                $em = $this->getDoctrine()->getManager();     
                $em->flush();


                return $this->redirectToRoute('genres');
            
            } 
            
            return $this->render('genres/edit.html.twig', [
                    'controller_name' => 'GenresController',
                    'genre' => $genre
                ]);
            
    }

    /**
     * @Route("/genres/{id}/suppression", name="genres_delete")
     */
    
    public function delete($id, Request $request): Response
    {
                $genre = $this->getDoctrine()
                ->getRepository(Genre::class)
                ->find($id);
            

                $em = $this->getDoctrine()->getManager();  
                $em->remove($genre);
                $em->flush();


                return $this->redirectToRoute('genres');
            
             
            
    }
}
