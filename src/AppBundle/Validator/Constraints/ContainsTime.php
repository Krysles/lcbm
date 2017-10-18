<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsTime extends Constraint
{
    public $message = 'Le temps de préparation doit être renseigné';

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
}