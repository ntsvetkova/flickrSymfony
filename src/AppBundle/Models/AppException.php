<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 26.08.15
 * Time: 17:42
 */

namespace AppBundle\Models;

/**
 * Class AppException
 * @package AppBundle\Models
 */
class AppException extends  \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": {$this->message}";
    }
}