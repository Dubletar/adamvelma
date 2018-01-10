<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Rest\Get("/users")
     */
    public function getAction()
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if ($users === null || empty($users)) {
            return $this->json(false,"no users exist", Response::HTTP_NOT_FOUND);
        }
        return $this->json($users);
    }

    /**
     * @Rest\Get("/user/{id}")
     */
    public function idAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if ($user === null) {
            return $this->json(false,"user not found", Response::HTTP_NOT_FOUND);
        }

        return $this->json($user);
    }

    /**
     * @Rest\Post("/user/create")
     */
    public function postAction(Request $request)
    {
        $data = new User;
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $password = $request->get('password');
        $email = $request->get('email');
        if(empty($firstName) || empty($lastName) || empty($password) || empty($email))
        {
            return $this->json(false, "NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setFirstName($firstName);
        $data->setLastName($lastName);
        $data->setEmailAddress($email);
        $data->setPassword(md5($password));

        $validator = $this->get('validator');
        $errors = $validator->validate($data);

        if (count($errors) > 0) {
            $violations = [];

            foreach ($errors as $error) {
                $message = (string) $error;
                $message = explode(":", $message);
                array_shift($message);

                array_push($violations, trim(implode(" ", $message)));
            }

            return $this->json(false, $violations);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return $this->json(true, "User Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/user/update/{id}")
     */
    public function updateAction($id,Request $request)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (empty($user)) {
            return $this->json(false, "user not found", Response::HTTP_NOT_FOUND);
        }

        if ($firstName = $request->get("firstName")) {
            $user->setFirstName($firstName);
        }

        if ($lastName = $request->get("lastName")) {
            $user->setLastName($lastName);
        }

        if ($email = $request->get("email")) {
            $user->setEmailAddress($email);
        }

        if ($password = $request->get("password")) {
            $user->setPassword(md5($password));
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->json(true, "User Updated Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/user/drop/{id}")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (empty($user)) {
            return $this->json(false, "user not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $em->remove($user);
            $em->flush();
        }

        return $this->json(true, "Deleted Successfully", Response::HTTP_OK);
    }
}