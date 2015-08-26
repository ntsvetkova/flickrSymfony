<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 26.08.15
 * Time: 10:43
 */

namespace AppBundle\Models;

/**
 * Class FlickrPhoto
 * @package AppBundle\Models
 */
class FlickrPhoto
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $owner;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $srcLarge;
    /**
     * @var string
     */
    protected $srcThumbnail;

    /**
     * @param $id
     * @param $owner
     * @param $title
     */
    public function __construct($id, $owner, $title) {
        $this->id = $id;
        $this->owner = $owner;
        $this->title = $title;
    }

    /**
     * @param $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $owner
     */
    public function setOwner($owner) {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * @param $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $srcLarge
     */
    public function setSrcLarge($srcLarge)
    {
        $this->srcLarge = $srcLarge;
    }

    /**
     * @return mixed
     */
    public function getSrcLarge()
    {
        return $this->srcLarge;
    }

    /**
     * @param mixed $srcThumbnail
     */
    public function setSrcThumbnail($srcThumbnail)
    {
        $this->srcThumbnail = $srcThumbnail;
    }

    /**
     * @return mixed
     */
    public function getSrcThumbnail()
    {
        return $this->srcThumbnail;
    }

}