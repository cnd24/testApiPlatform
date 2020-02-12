<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class ArticleController
 * @package App\Controller
 * @Serializer\ExclusionPolicy("all")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="article_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
       $data = $request->getContent();  //récupération des données envoyées par l'user
       $article = $this->get('serializer') //appel du service serializer
           ->deserialize($data, 'App\Entity\Article', 'json');
                        //les données à récupérer, l'objet que l'on souhaite obtenir, ce qui est à désérialiser

       $entityManager = $this->getDoctrine()->getManager();
       $entityManager->persist($article); //
       $entityManager->flush();

       return new Response('', Response::HTTP_CREATED);
                // retourner une réponse à contenu vide avec un code 201 (HTTP_CREATED)
    }

    /**
     * @Route("/articles/{id}", name="article_show", methods={"GET"})
     */
    public function showAction(Article $article)
    {
        $data = $this->get('serializer')->serialize($article, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/articles", name="article_list", methods={"GET"})
     */
    public function listAction()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        $data = $this->get('serializer')->serialize($articles, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
}
