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
        $this->response = json_decode($response);
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
        for ($i = 0; $i < count($this->response->photos->photo); $i++) {
            $this->photo = new FlickrPhoto($this->response->photos->photo[$i]->id, $this->response->photos->photo[$i]->owner, $this->response->photos->photo[$i]->title);
            array_push($this->arrayPhotos, $this->photo);
        }
        return $this->arrayPhotos;
    }

    /**
     * @return FlickrPhoto
     */
    public function decodeSizes() {
        $this->photo->setSrcLarge($this->response->sizes->size[count($this->response->sizes->size) - 1]->source);
        for ($i = 0; $i < count($this->response->sizes->size); $i++) {
            if ($this->response->sizes->size[$i]->label == "Thumbnail") {
                $this->photo->setSrcThumbnail($this->response->sizes->size[$i]->source);
            }
        }
        return $this->photo;
    }

}