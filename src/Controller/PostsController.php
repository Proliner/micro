<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsType;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/posts")
 */
class PostsController extends Controller
{
    /**
     * @Route("/", name="posts_index", methods="GET")
     */
    public function index(PostsRepository $postsRepository): Response
    {
        return $this->render('posts/index.html.twig', ['posts' => $postsRepository->findAll()]);
    }

    /**
     * @Route("/new", name="posts_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        //new instance Posts model
        $post = new Posts();
        //building the form
        $form = $this->createForm(PostsType::class, $post);
        //setting up the request
        $form->handleRequest($request);

        // handle the submit
        if ($form->isSubmitted() && $form->isValid()) {

            //set timezone
            date_default_timezone_set('Europe/Amsterdam');
            //set the created at date
            $post->setCreatedAt(\DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s")));

            //save the post
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            //add flash message
            $this->addFlash('success', 'Bericht is toegevoegd!');

            //return to the index
            return $this->redirectToRoute('posts_index');
        }

        //return the view with post and form variables
        return $this->render('posts/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="posts_show", methods="GET")
     */
    public function show(Posts $post): Response
    {
        return $this->render('posts/show.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/{id}/edit", name="posts_edit", methods="GET|POST")
     */
    public function edit(Request $request, Posts $post): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('posts_edit', ['id' => $post->getId()]);
        }

        return $this->render('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="posts_delete", methods="DELETE")
     */
    public function delete(Request $request, Posts $post): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('posts_index');
    }
}
