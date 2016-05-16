<?php

namespace Demos\BlogBundle\Controller;

use Demos\BlogBundle\DemosBlogBundle;
use Demos\BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/blog")
     */
    public function indexAction()
    {
        return $this->render('DemosBlogBundle:Default:index.html.twig');
    }

    /**
     * @Route("/create")
     */
    public function createAction(){
        $post = new Post();
        $post->setTitle("Demo blog");
        $post->setBody("Hello Symfony 2");
        $post->setCreateDate(new \DateTime("now"));
        $post->setUpdateDate(new \DateTime("now"));

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($post);
        $em->flush();

        return new Response("Create post id " . $post->getId());
    }

    /**
     * @Route("/show/{id}")
     * @Template()
     */

    public function showAction($id){
        $post = $this->getDoctrine()
            ->getRepository("DemosBlogBundle:Post")
            ->find($id);

        if(!$post){
            throw $this->createNotFoundException('Page not found!');
        }



        return array('post' => $post);
    }
}
