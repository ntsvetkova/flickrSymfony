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
     * @var
     */
//    private static $instance;
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
     * @return mixed
     */
//    public static function getInstance() {
//        if (empty(self::$instance)) {
//            $classname = __CLASS__;
//            self::$instance = new $classname;
//        }
//        return self::$instance;
//    }

    /**
     * @return resource
     */
    public function getHandle() {
        return $this->handle;
    }

    public function curlExec($url) {
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1
        ];
        curl_setopt_array($this->handle, $options);
        return curl_exec($this->handle);
    }

    /**
     * Restricted to clone
     */
//    private function __clone() {}

    /**
     * Destructor
     */
    public function __destructor() {
        curl_close($this->handle);
    }
}