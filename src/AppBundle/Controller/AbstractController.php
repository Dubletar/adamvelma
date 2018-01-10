<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractController extends FOSRestController
{
    /**
     * Returns a JsonResponse that uses the serializer component if enabled, or json_encode.
     *
     * @param mixed $data    The response data
     * @param mixed $message This can be a string or an array of strings
     * @param int   $status  The status code to use for the Response
     * @param boolean $serialize
     * @param array $headers Array of extra headers to add
     * @param array $context Context to pass to serializer when using serializer component
     *
     * @return JsonResponse
     */
    protected function json($data, $message = "success", $status = 200, $headers = array(), $context = array())
    {
        /**
         * Create a data object to hold a message along with the original data.
         */
        $dataObject = [];
        $dataObject["data"] = $data;
        $dataObject["message"] = $message;

        if ($this->container->has('serializer')) {
            $json = $this->container->get('serializer')->serialize($dataObject, 'json', array_merge(array(
                'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
            ), $context));

            return new JsonResponse($json, $status, $headers, true);
        }

        return new JsonResponse($dataObject, $status, $headers);
    }
}