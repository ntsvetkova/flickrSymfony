<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 08.09.15
 * Time: 18:02
 */

namespace AppBundle\Models\Registration;


class RegistrationData
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $email;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


}