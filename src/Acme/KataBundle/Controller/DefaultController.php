<?php

namespace Acme\KataBundle\Controller;

use Acme\KataBundle\Entity\Article;
use Acme\KataBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $article = new Article();

        $form = $this->createForm('article', $article);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('edit', array('id' => $article->getId())));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/edit/{id}", name="edit")
     * @Template("AcmeKataBundle:Default:index.html.twig")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AcmeKataBundle:Article')->find($id);

        if (!$article) {
            throw $this->createNotFoundException('No article found for is '.$id);
        }

        $originalCategories = new ArrayCollection($article->getCategories()->toArray());

        $editForm = $this->createForm('article', $article, array('action' => $this->generateUrl('edit', array('id' => $article->getId()))));

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            foreach($originalCategories as $category) {
                if (false === $article->getCategories()->contains($category)) {
                    $em->remove($category);
                }
            }

            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('success'));
        }

        return array('form' => $editForm->createView());
    }

    /**
     * @Route("/success", name="success")
     */
    public function successAction()
    {
        return new Response('success');
    }
}
