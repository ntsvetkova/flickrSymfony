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
    private $endPoint = "https://api.flickr.com/services/rest";
    /**
     * @var string
     */
    private $apiKey = "3bd97586d21ffcffe1931f53c2883652";
    /**
     * @var string
     */
    private $format = "json";
    /**
     * @var
     */
    private static $instance;

    /**
     * Constructor
     */
    public function __construct() {}

    /**
     * @return mixed
     */
    public static function getInstance() {
        if (empty(self::$instance)) {
            $classname = __CLASS__;
            self::$instance = new $classname;
        }
        return self::$instance;
    }

    /**
     * @return string
     */
    public function getEndPoint() {
        return $this->endPoint;
    }

    /**
     * Restricted to clone
     */
    private function __clone() {}

    /**
     * @return mixed
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
     * @return mixed
     */
    public function getSizes($id) {
        $query = array(
            'method' => 'flickr.photos.getSizes',
            'format' => $this->format,
            'api_key' => $this->apiKey,
            'id' => $id
        );
        return $query;
    }
}