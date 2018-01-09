<?php

namespace AppBundle\Controller;
use AppBundle\Service\PDFService;
use RobbieP\ZbarQrdecoder\ZbarDecoder;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use UtilityBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/")
 */
class AppController extends AbstractController
{
    /**
     * @Route("/", name="index", options={"expose":true})
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $filepath = __DIR__ . '/../../../web/assets/testlog'.time().rand(1000,9999).'.txt';
        $file = fopen($filepath, 'w') or die ('unable to open ' . $filepath);

        fwrite($file, PHP_EOL . $request->getPathInfo());

        // retrieve $_SERVER variables
        fwrite($file, PHP_EOL . $request->server->get('HTTP_HOST'));

        // retrieve a $_COOKIE value
        fwrite($file, PHP_EOL . $request->cookies->get('PHPSESSID'));

        // retrieve an HTTP request header, with normalized, lowercase keys
        fwrite($file, PHP_EOL . $request->headers->get('host'));
        fwrite($file, PHP_EOL . $request->headers->get('content_type'));

        fwrite($file, PHP_EOL . $request->getMethod());
        fclose($file);
        return new Response('OK');
    }
}