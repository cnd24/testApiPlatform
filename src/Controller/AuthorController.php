<?php

namespace App\Controller;

use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AuthorController extends AbstractController
{
    /**
     * @Route("/authors/{id}", name="author_show")
     */
    public function showAction(Author $author, SerializerInterface $serializer)
    {
        $data = $serializer->serialize($author, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }


    /**
     * @Route("/authors", name="author_create", methods={"POST"})
     */
    public function createAction(Request $request, SerializerInterface $serializer)
    {
        $data = $request->getContent();
        $author = $serializer->deserialize($data, Author::class, 'json');

        $em  =$this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }


}
