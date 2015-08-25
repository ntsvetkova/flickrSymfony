<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $srclarge = '';
        $srcthumbnail = '';
        $title = 'Title';
        $id = 'id';
        $owner = 'owner';

        return $this->render('flickrPhoto/photo.html.twig', array('srclarge' => $srclarge,
            'srcthumbnail' => $srcthumbnail,
            'title' => $title,
            'id' => $id,
            'owner' => $owner,
        ));
    }
}
