<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 28.08.15
 * Time: 9:40
 */

namespace AppBundle\Exceptions;

/**
 * Class AppException
 * @package AppBundle\Exceptions
 */
class AppException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    public function __toString() {
        return $this->message;
    }

}