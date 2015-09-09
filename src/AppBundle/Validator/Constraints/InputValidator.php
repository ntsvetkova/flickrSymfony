<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 31.08.15
 * Time: 15:12
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class InputValidator extends ConstraintValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        if (empty($value)) {
            $this->context->buildViolation($constraint->emptyMessage)
                ->addViolation();
        }
        else if (!preg_match("/(\d\s\d)\s+(((\d\s){2}[NSWE]{1})\s+([LRM]+)\s*)+$/", $value)) {
            $this->context->buildViolation($constraint->errorMessage)
                ->addViolation();
        }
    }
}