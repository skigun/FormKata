<?php

namespace Acme\KataBundle\Controller;

use Acme\KataBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder\Finder;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $path = __DIR__.'/../Entity/article.xml';

        $article = simplexml_load_file($path);

        $form = $this->createForm('article', $article);

        $form->handleRequest($request);
        if ($form->isValid()) {
            // we save the xml into the file
            $article->saveXML($path);

            $response = new Response($article->saveXML());

            $response->headers->set('Content-type', 'text/xml');

            return $response;
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/success", name="success")
     */
    public function successAction()
    {
        return new Response('success');
    }
}
