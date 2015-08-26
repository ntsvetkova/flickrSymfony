<?php

namespace AppBundle\Controller;
//use AppBundle\Models\FlickrPhoto;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

//require_once __DIR__ . '/../Models/FlickrPhoto.php';

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
//    private  $photo;
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $requestParameters = $this->get('request_parameters');

        $request = Request::create($requestParameters->getEndPoint(), 'GET',
            $requestParameters->getRecent());
//        $requestStack = new RequestStack();
//        $requestStack->push($request);
        var_dump($request);

        $sendRequest = $this->get('curl');
        $data = $sendRequest->curlExec();





        return new Response($request);
        //    $this->render ('flickrPhoto/photo.html.twig', array('srclarge' => $this->photo->getSrcLarge(),
//            'srcthumbnail' => $this->photo->getSrcThumbnail(),
//            'title' => $this->photo->getTitle(),
//            'id' => $this->photo->getId(),
//            'owner' => $this->photo->getOwner(),
//        $srclarge = '';
//        $srcthumbnail = '';
//        $title = 'Title';
//        $id = 'id';
//        $owner = 'owner';
//
//        return $this->render('flickrPhoto/photo.html.twig', array('srclarge' => $srclarge,
//            'srcthumbnail' => $srcthumbnail,
//            'title' => $title,
//            'id' => $id,
//            'owner' => $owner,
//        ));
    }

}
