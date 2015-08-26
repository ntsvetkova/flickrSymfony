<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 26.08.15
 * Time: 12:59
 */

namespace AppBundle\Models;
use AppBundle\Controller\DefaultController;
use AppBundle\Models\FlickrPhoto;

require_once __DIR__ . '/../Models/FlickrPhoto.php';

/**
 * Class ResponseDecode
 * @package AppBundle\Models
 */
class ResponseDecode
{
    /**
     * @var
     */
    private $response;
    /**
     * @var FlickrPhoto
     */
    protected $photo;
    /**
     * @var array
     */
    protected $arrayPhotos = [];
    /**
     * @var
     */
    private static $instance;

    /**
     * Constructor
     */
    private function __construct() {}

    /**
     * @param FlickrPhoto $photo
     */
    public function setPhoto(FlickrPhoto $photo = null) {
        $this->photo = $photo;
    }

    /**
     * @return FlickrPhoto
     */
    public function getPhoto() {
        return $this->photo;
    }

    /**
     * @param $response
     */
    public function setResponse($response) {
        $this->response = $response;
    }

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
     * @return array
     */
    public function decodeRecent() {
        $obj = json_decode($this->response);
        for ($i = 0; $i < count($obj->photos->photo); $i++) {
            $this->photo = new FlickrPhoto($obj->photos->photo[$i]->id, $obj->photos->photo[$i]->owner, $obj->photos->photo[$i]->title);
            array_push($this->arrayPhotos, $this->photo);
        }
        return $this->arrayPhotos;
    }

    /**
     * @return FlickrPhoto
     */
    public function decodeSizes() {
        $obj = json_decode($this->response);
        $this->photo->setSrcLarge($obj->sizes->size[count($obj->sizes->size) - 1]->source);
        for ($i = 0; $i < count($obj->sizes->size); $i++) {
            if ($obj->sizes->size[$i]->label == "Thumbnail") {
                $this->photo->setSrcThumbnail($obj->sizes->size[$i]->source);
            }
        }
        return $this->photo;
    }

}