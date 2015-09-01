<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 31.08.15
 * Time: 15:11
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Input
 * @package AppBundle\Validator
 * @Annotation
 */
class Input extends Constraint
{
    public $message = 'input.error';
}