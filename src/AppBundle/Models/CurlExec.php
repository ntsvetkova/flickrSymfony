<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 25.08.15
 * Time: 19:25
 */

namespace AppBundle\Models;
use Symfony\Component\HttpFoundation\RequestStack;

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
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack) {
        $this->requestStack = $requestStack;
        $this->handle = curl_init();
    }

    /**
     * @return resource
     */
    public function getHandle() {
        return $this->handle;
    }

    /**
     * @return string
     */
    public function curlExec() {
        $request = $this->requestStack->getCurrentRequest();
        $options = [
            CURLOPT_URL => 'https://' . $request->getHttpHost() . $request->getRequestUri(),
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