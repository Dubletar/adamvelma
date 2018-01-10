<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dog;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;

class DogController extends AbstractController
{
    /**
     * @Rest\Get("/dogs")
     */
    public function getAction()
    {
        $dogs = $this->getDoctrine()->getRepository('AppBundle:Dog')->findAll();
        if ($dogs === null || empty($dogs)) {
            return $this->json(false,"no dogs exist", Response::HTTP_NOT_FOUND);
        }
        return $this->json($dogs);
    }

    /**
     * @Rest\Get("/dog/{id}")
     */
    public function idAction($id)
    {
        $dog = $this->getDoctrine()->getRepository('AppBundle:Dog')->find($id);
        if ($dog === null) {
            return $this->json(false,"user not found", Response::HTTP_NOT_FOUND);
        }

        return $this->json($dog);
    }

    /**
     * @Rest\Post("/dog/create")
     */
    public function postAction(Request $request)
    {
        $data = new Dog;
        $name = $request->get('name');
        $breed = $request->get('breed');
        $description = $request->get('description');
        $age = $request->get('age');

        if(empty($name))
        {
            return $this->json(false, "NAME NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setName($name);
        $data->setBreed($breed);
        $data->setDescription($description);
        $data->setAge(intval($age));

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return $this->json(true, "Dog Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/dog/update/{id}")
     */
    public function updateAction($id,Request $request)
    {
        $dog = $this->getDoctrine()->getRepository('AppBundle:Dog')->find($id);
        if (empty($dog)) {
            return $this->json(false, "dog not found", Response::HTTP_NOT_FOUND);
        }

        if ($name = $request->get("name") && trim($request->get("name"))) {
            $dog->setName($name);
        }

        if ($breed = $request->get("breed")) {
            $dog->setBreed($breed);
        }

        if ($description = $request->get("description")) {
            $dog->setDescription($description);
        }

        if ($age = $request->get("age")) {
            $dog->setAge(intval($age));
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->json(true, "Dog Updated Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/dog/drop/{id}")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $dog = $this->getDoctrine()->getRepository('AppBundle:Dog')->find($id);
        if (empty($dog)) {
            return $this->json(false, "dog not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $em->remove($dog);
            $em->flush();
        }

        return $this->json(true, "Dog Deleted Successfully", Response::HTTP_OK);
    }
}