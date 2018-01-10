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
        $this->logRequestData();

        $q = $_REQUEST['q'];

        return new Response($q);
    }

    protected function logRequestData()
    {
        $filepath = __DIR__ . '/../../../web/assets/testlog.txt';
        $txt = json_encode($_REQUEST);
        $txt .= PHP_EOL . json_encode($_SERVER);
        $txt .= PHP_EOL . json_encode($_POST);
        $txt .= PHP_EOL . json_encode($_GET);
        $txt .= PHP_EOL . json_encode($_FILES);

        $file = file_put_contents($filepath, $txt, FILE_APPEND);
    }

}