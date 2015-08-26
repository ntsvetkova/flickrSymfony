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

    /**
     * @return Response
     */
    public function indexAction()
    {
        $responseDecode = $this->setData('getRecent', $this->photo);
        $arrayPhotos = $responseDecode->decodeRecent();
        foreach ($arrayPhotos as $photo) {
            $this->forward('AppBundle:Default:final', array(
                'photo' => $photo
            ));
        }
        return $this->render('flickrPhoto/photo.html.twig', array(
            'arrayPhotos' => $arrayPhotos
        ));
    }

    /**
     * @param FlickrPhoto $photo
     * @return Response
     */
    public function finalAction(FlickrPhoto $photo) {
        $responseDecode = $this->setData('getSizes', $photo);
        $this->photo = $responseDecode->decodeSizes();
        return new Response();
    }

    /**
     * @param $apiMethod
     * @param FlickrPhoto|null $photo
     * @return mixed
     */
    public function setData($apiMethod, FlickrPhoto $photo = null) {
        $requestParameters = $this->get('request_parameters');
        switch ($apiMethod) {
            case 'getRecent':
                $request = Request::create($requestParameters->getEndPoint(), 'GET',
                    $requestParameters->getRecent());
                break;
            case 'getSizes':
                $request = Request::create($requestParameters->getEndPoint(), 'GET',
                    $requestParameters->getSizes($photo->getId()));
                break;
            default:
                break;
        }
        $sendRequest = $this->get('curl');
        $data = $sendRequest->curlExec($request->getHttpHost() . $request->getRequestUri());

        $responseDecode = ResponseDecode::getInstance();
        $responseDecode->setPhoto($photo);
        $responseDecode->setResponse($data);
        return $responseDecode;
    }

}
