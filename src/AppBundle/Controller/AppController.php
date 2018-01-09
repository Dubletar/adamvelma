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
        $filepath = __DIR__ . '/../../../web/assets/testlog.txt';
        $file = fopen($filepath, 'w') or die ('unable to open ' . $filepath);
        fwrite($file, $request->getPathInfo());
        fwrite($file, PHP_EOL . '====================================');
        fclose($file);
        return new Response('done');
    }
}