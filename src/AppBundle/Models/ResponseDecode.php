<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 26.08.15
 * Time: 12:59
 */

namespace AppBundle\Models;

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
     * @param $response
     */
    public function __construct($response) {
        $this->response = $response;
    }
}