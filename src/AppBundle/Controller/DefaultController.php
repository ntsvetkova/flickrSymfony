<?php

namespace AppBundle\Controller;
use AppBundle\Models\FlickrPhoto;
use AppBundle\Models\ResponseDecode;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../Models/FlickrPhoto.php';
require_once __DIR__ . '/../Models/ResponseDecode.php';

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

//    public function indexAction(Request $request) {
//        $this->redirectToRoute('flickrPhotos', array(), 301);
//        return new Response($request);
//    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getRecentAction(Request $request) {
        $requestInfo = $this->setRequest('getRecent', $this->photo);
        $request->initialize($requestInfo->query->all(), $requestInfo->request->all(),
            $requestInfo->attributes->all(), $requestInfo->cookies->all(), $requestInfo->files->all(),
            $requestInfo->server->all(), $requestInfo->getContent());
        $responseDecode = $this->setData($this->photo);
        $arrayPhotos = $responseDecode->decodeRecent();
        foreach ($arrayPhotos as $photo) {
            $this->forward('AppBundle:Default:getSizes', array(
                'photo' => $photo
            ));
        }
        return $this->render('flickrPhoto/photo.html.twig', array(
            'arrayPhotos' => $arrayPhotos
        ));
    }

    /**
     * @param FlickrPhoto $photo
     * @param Request $request
     * @return Response
     */
    public function getSizesAction(FlickrPhoto $photo, Request $request) {
        $requestInfo = $this->setRequest('getSizes', $photo);
        $request->initialize($requestInfo->query->all(), $requestInfo->request->all(),
            $requestInfo->attributes->all(), $requestInfo->cookies->all(), $requestInfo->files->all(),
            $requestInfo->server->all(), $requestInfo->getContent());
        $responseDecode = $this->setData($photo);
        $this->photo = $responseDecode->decodeSizes();
        return new Response();
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
        switch ($apiMethod) {
            case 'getRecent':
                $requestInfo = Request::create($requestParameters->getEndPoint(), 'GET',
                    $requestParameters->getRecent());
                break;
            case 'getSizes':
                $requestInfo = Request::create($requestParameters->getEndPoint(), 'GET',
                    $requestParameters->getSizes($photo->getId()));
                break;
            default:
                break;
        }
        return $requestInfo;
    }

}
