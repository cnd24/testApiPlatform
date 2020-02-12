<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="article_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
       $data = $request->getContent();
       $article = $this->get('serializer')
           ->deserialize($data, 'App\Entity\Article', 'json');

       $entityManager = $this->getDoctrine()->getManager();
       $entityManager->persist($article);
       $entityManager->flush();

       return new Response('', Response::HTTP_CREATED);
    }
}
