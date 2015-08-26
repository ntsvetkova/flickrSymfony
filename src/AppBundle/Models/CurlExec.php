<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 25.08.15
 * Time: 19:25
 */

namespace AppBundle\Models;

/**
 * Class CurlExec
 * @package AppBundle\Models
 */
class CurlExec
{
    /**
     * @var resource
     */
    private $handle;

    /**
     * Constructor
     */
    public function __construct() {
        $this->handle = curl_init();
    }

    /**
     * @return resource
     */
    public function getHandle() {
        return $this->handle;
    }

    /**
     * @param $url
     * @return mixed
     */
    public function curlExec($url) {
        $options = [
            CURLOPT_URL => 'https://' . $url,
            CURLOPT_RETURNTRANSFER => 1
        ];
        curl_setopt_array($this->handle, $options);
        return substr(curl_exec($this->handle), 14, -1);
    }

    /**
     * Destructor
     */
    public function __destructor() {
        curl_close($this->handle);
    }
}