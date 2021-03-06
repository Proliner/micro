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
 * @Route("/")
 */
class PostsController extends Controller
{
    /**
     * @Route("/", name="posts_index", methods="GET")
     */
    public function index(PostsRepository $postsRepository): Response
    {
        //return the index view with all the posts sorted by DESC
        return $this->render('posts/index.html.twig', ['posts' => $postsRepository->findAllOrderedByDesc()]);
    }

    /**
     * @Route("post/new", name="posts_new", methods="GET|POST")
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
            //set the created at date
            $post->setCreatedAt(new \DateTime('now'));

            //save the post
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            //add flash message
            $this->addFlash('success', 'Bericht is toegevoegd.');

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
     * @Route("post/{id}", name="posts_show", methods="GET")
     */
    public function show(Posts $post): Response
    {
        return $this->render('posts/show.html.twig', ['post' => $post]);
    }

    /**
     * @Route("post/{id}/edit", name="posts_edit", methods="GET|POST")
     */
    public function edit(Request $request, Posts $post): Response
    {
        //create the form with the current post information
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        //check of the form is submitted and if so check for the validation
        if ($form->isSubmitted() && $form->isValid()) {

            //make the changes in the db
            $this->getDoctrine()->getManager()->flush();

            //add flash message
            $this->addFlash('success', 'Bericht is aangepast.');

            //back to the index
            return $this->redirectToRoute('posts_index');
        }

        //render the view
        return $this->render('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("post/{id}", name="posts_delete", methods="DELETE")
     */
    public function delete(Request $request, Posts $post): Response
    {
        //check for the csrf token
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            //remove the post from the db
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        //add flash message
        $this->addFlash('success', 'Bericht is verwijderd.');

        //When the post is deleted the user gets redirected to the index page
        return $this->redirectToRoute('posts_index');
    }
}
