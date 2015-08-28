<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 25.08.15
 * Time: 16:55
 */

namespace AppBundle\Models;
use AppBundle\Controller\DefaultController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestParameters
 * @package AppBundle\Models
 */
class RequestParameters
{
    /**
     * @var string
     */
    private $endPoint;
    /**
     * @var string
     */
    private $apiKey;
    /**
     * @var string
     */
    private $format;

    /**
     * @param $apiKey
     * @param $format
     */
    public function __construct($apiKey, $format) {
//    public function __construct($endPoint, $apiKey, $format) {
//        $this->endPoint = $endPoint;
        $this->apiKey = $apiKey;
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getEndPoint() {
        return $this->endPoint;
    }

    /**
     * @return array
     */
    public function getRecent() {
        $query = array(
            'method' => 'flickr.photos.getRecent',
            'format' => $this->format,
            'api_key' => $this->apiKey,
            'per_page' => 3
        );
        return $query;
    }

    /**
     * @param $id
     * @return array
     */
    public function getSizes($id) {
        $query = array(
            'method' => 'flickr.photos.getSizes',
            'format' => $this->format,
            'api_key' => $this->apiKey,
            'photo_id' => $id
        );
        return $query;
    }
}