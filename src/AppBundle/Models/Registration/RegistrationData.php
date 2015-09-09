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

class RegistrationData extends SignInData
{
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $country;

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

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraint('name', new Length([
            'min' => 3,
            'max' => 15,
            'minMessage' => 'value.short',
            'maxMessage' => 'value.long'
        ]));
        $metadata->addPropertyConstraint('country', new NotBlank([
            'message' => 'value.empty'
        ]));
        $metadata->addPropertyConstraint('country', new Country([
            'message' => 'value.error'
        ]));
        $metadata->addPropertyConstraint('email', new Email());
        $metadata->addPropertyConstraint('email', new NotBlank([
            'message' => 'value.empty'
        ]));
    }

}