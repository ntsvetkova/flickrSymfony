<?php

namespace AppBundle\Controller;

use AppBundle\Models\RequestParameters;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../Models/RequestParameters.php';

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        $requestParameters = RequestParameters::getInstance();

        $request = Request::create($requestParameters->getEndPoint() .
            $this->get('router')->generate('homepage', $requestParameters->getRecent()));

//        var_dump($request);

        $test = $this->get('request_parameters');
        var_dump($test);

        return new Response($request);
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
