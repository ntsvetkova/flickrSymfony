<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 09.09.15
 * Time: 13:37
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
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
 * @UniqueEntity(fields="_username", message="value.same")
 */
class User implements UserInterface, \Serializable
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
    protected $_username;
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
    protected $_password;

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
     * @return string The username
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
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
        return $this->_password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraints('_username', [
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
        $metadata->addPropertyConstraints('_password', [
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

    /**
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN', 'ROLE_USER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {

    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->_username,
            $this->country,
            $this->email,
            $this->_password
        ]);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->_username,
            $this->country,
            $this->email,
            $this->_password
        ) = unserialize($serialized);
    }
}