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
        $doctrine = $this->getDoctrine();
        $test = $doctrine->getRepository('AppBundle:Test')->findAll();

        if (!count($test)) {
            $count = 0;
            $test = new Test();
            $test->setCount($count);

            $em = $doctrine->getManager();
            $em->persist($test);
            $em->flush();
        } else {
            $test = $test[0];
            $count = $test->getCount();
        }

        switch($count) {
            case 9;
                $count = 0;
                break;
            default:
                $count++;
        }

        $test->setCount($count);
        $em = $doctrine->getManager();
        $em->persist($test);
        $em->flush();

        return new Response($count);
    }
}