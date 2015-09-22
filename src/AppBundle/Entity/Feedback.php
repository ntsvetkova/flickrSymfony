<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 22.09.15
 * Time: 15:17
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Class Feedback
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="feedback")
 */
class Feedback {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $username;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $email;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $message;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraints('username', [
            new NotBlank([
                'message' => 'value.empty'
            ]),
            new Length([
                'min' => 3,
                'max' => 30,
                'minMessage' => 'value.short',
                'maxMessage' => 'value.long'
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
        $metadata->addPropertyConstraints('message', [
            new NotBlank([
                'message' => 'value.empty'
            ]),
            new Length([
                'min' => 2,
                'max' => 200,
                'minMessage' => 'value.short',
                'maxMessage' => 'value.long'
            ])
        ]);
    }

}