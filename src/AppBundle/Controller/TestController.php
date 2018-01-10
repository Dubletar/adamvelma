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

        $q = strtolower($_REQUEST['q']);

        switch($q) {
            case 'status':
                $response = "YES";
                break;
            case 'degree':
                $response = "I'm a self-taught programmer. I already knew how to code before I went to Devry. I started Devry, but stopped, deciding against the debt.";
                break;
            case 'name':
                $response = "Adam Velma";
                break;
            case 'phone':
                $response = "773.726.3917";
                break;
            case 'resume':
                $response = "LINK";
                break;
            case 'years':
                $response = "6+";
                break;
            case 'referrer':
                $response = "Indeed.com";
                break;
            case 'email':
                $response = "dubletar@gmail.com";
                break;
            case 'source':
                $response = "https://github.com/Dubletar/adamvelma";
                break;
            case 'position':
                $response = "Front-End/Full-Stack Software Engineer";
                break;
            default:
                $response = "OK";
        }

        return new Response($response);
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