<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dog;
use AppBundle\Entity\Test;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;

class TestController extends AbstractController
{
    /**
     * @Rest\Get("/")
     */
    public function getAction()
    {
        $filepath = __DIR__ . '/../../../web/assets/testlog.txt';
        $txt = json_encode($_GET);

        $file = file_put_contents($filepath, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

        return new Response("OK");
    }
}