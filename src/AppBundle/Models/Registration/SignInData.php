<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 09.09.15
 * Time: 9:47
 */

namespace AppBundle\Models\Registration;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SignInData
{
    /**
     * @var string
     */
    protected $_username;
    /**
     * @var string
     */
    protected $_password;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraint('_username', new NotBlank([
            'message' => 'value.empty'
        ]));
        $metadata->addPropertyConstraint('_password', new NotBlank([
            'message' => 'value.empty'
        ]));
    }
}