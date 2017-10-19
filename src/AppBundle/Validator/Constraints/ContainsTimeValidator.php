<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsTimeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value->format('H:i') == "00:00") {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}