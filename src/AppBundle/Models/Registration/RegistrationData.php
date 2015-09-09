<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 08.09.15
 * Time: 18:02
 */

namespace AppBundle\Models\Registration;

use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationData
{
    /**
     * @Assert\Type(type="AppBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

}