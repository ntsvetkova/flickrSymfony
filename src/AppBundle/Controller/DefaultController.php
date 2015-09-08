<?php

namespace AppBundle\Controller;
use AppBundle\Exceptions\AppException;
use AppBundle\Models\FlickrPhoto\FlickrPhoto;
use AppBundle\Models\FlickrPhoto\ResponseDecode;

use AppBundle\Models\Mars\MarsType;
use AppBundle\Models\Mars\SetData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @var FlickrPhoto
     */
    private $photo;

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request) {
        return $this->render('menu.html.twig', array());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function menuAction(Request $request) {
        $response = new JsonResponse();
        $content = json_encode(['items' => [
            ['text' => $this->get('translator')->trans('flickr.photos'), 'path' => $this->generateUrl('flickrPhotos')],
            ['text' => $this->get('translator')->trans('mars'), 'path' => $this->generateUrl('exploringMars')],
        ]]);
        $response->setContent($content);
        return $response;
//        return new Response();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getRecentAction(Request $request) {
        $requestInfo = $this->setRequest('getRecent', $this->photo);
        if ($requestInfo instanceof Request) {
            $request->initialize($requestInfo->query->all(), $requestInfo->request->all(),
                $requestInfo->attributes->all(), $requestInfo->cookies->all(), $requestInfo->files->all(),
                $requestInfo->server->all(), $requestInfo->getContent());
            $responseDecode = $this->setData($this->photo);
            $arrayPhotos = $responseDecode->decodeRecent();
            foreach ($arrayPhotos as $photo) {
                $response = $this->forward('AppBundle:Default:getSizes', array(
                    'photo' => $photo
                ));
                if ($response->getContent() == $this->get('translator')->trans('no.method')) {
                    return $this->render('flickrPhoto/error.html.twig', array(
                        'message' => $response->getContent()));
                }
            }
            return $this->render('flickrPhoto/photo.html.twig', array(
                'arrayPhotos' => $arrayPhotos,
                'count' => count($arrayPhotos)
            ));
        }
        else {
            return $this->render('flickrPhoto/error.html.twig', array(
                'message' => $requestInfo
            ));
        }
    }

    /**
     * @param FlickrPhoto $photo
     * @param Request $request
     * @return Response
     */
    public function getSizesAction(FlickrPhoto $photo, Request $request) {
        $requestInfo = $this->setRequest('getSizes', $photo);
        if ($requestInfo instanceof Request) {
            $request->initialize($requestInfo->query->all(), $requestInfo->request->all(),
                $requestInfo->attributes->all(), $requestInfo->cookies->all(), $requestInfo->files->all(),
                $requestInfo->server->all(), $requestInfo->getContent());
            $responseDecode = $this->setData($photo);
            $this->photo = $responseDecode->decodeSizes();
            return new Response();
        }
        else {
            return new Response($requestInfo);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function marsAction(Request $request) {
        $setData = new SetData();
        $results = [];
        $form = $this->createForm($this->get('mars_type'), $setData);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $setData->setAll();
            $results = $setData->execute();
        }
        return $this->render('mars/mars.html.twig', array(
            'form' => $form->createView(),
            'results' => $results
        ));
    }

    /**
     * @param FlickrPhoto|null $photo
     * @return mixed
     */
    public function setData(FlickrPhoto $photo = null) {
        $sendRequest = $this->get('curl');
        $data = $sendRequest->curlExec();
        $responseDecode = ResponseDecode::getInstance();
        $responseDecode->setPhoto($photo);
        $responseDecode->setResponse($data);
        return $responseDecode;
    }

    /**
     * @param $apiMethod
     * @param FlickrPhoto|null $photo
     * @return Request
     *
     */
    public function setRequest($apiMethod, FlickrPhoto $photo = null) {
        $requestParameters = $this->get('request_parameters');
        try {
            switch ($apiMethod) {
                case 'getRecent':
                    $requestInfo = Request::create($this->container->getParameter('end_point'), 'GET',
                        $requestParameters->getRecent());
                    break;
                case 'getSizes':
                    $requestInfo = Request::create($this->container->getParameter('end_point'), 'GET',
                        $requestParameters->getSizes($photo->getId()));
                    break;
                default:
                    throw new AppException('no.method');
            }
        }
        catch (AppException $e) {
            $requestInfo = $this->get('translator')->trans($e);
        }
        return $requestInfo;
    }
}
