<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 09.09.15
 * Time: 13:37
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @UniqueEntity(fields="name", message="value.same")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $email;
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $country;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraints('name', [
            new Length([
                'min' => 3,
                'max' => 15,
                'minMessage' => 'value.short',
                'maxMessage' => 'value.long'
            ]),
            new NotBlank([
                'message' => 'value.empty'
            ])
        ]);
        $metadata->addPropertyConstraints('country', [
            new NotBlank([
                'message' => 'value.empty'
            ]),
            new Country([
                'message' => 'value.error'
            ])
        ]);
        $metadata->addPropertyConstraints('email', [
            new Email([
                'message' => 'value.email.error'
            ]),
            new NotBlank([
                'message' => 'value.empty'
            ])
        ]);
        $metadata->addPropertyConstraints('password', [
            new Length([
                'min' => 3,
                'max' => 4096,
                'minMessage' => 'value.short',
                'maxMessage' => 'value.long'
            ]),
            new NotBlank([
                'message' => 'value.empty'
            ])
        ]);
    }

}