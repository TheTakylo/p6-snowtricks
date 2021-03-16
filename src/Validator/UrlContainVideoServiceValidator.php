<?php

namespace App\Validator;

use App\Service\VideoService\VideoServiceFinder;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UrlContainVideoServiceValidator extends ConstraintValidator
{
    /** @var VideoServiceFinder */
    private $videoServiceFinder;

    public function __construct(VideoServiceFinder $videoServiceFinder)
    {
        $this->videoServiceFinder = $videoServiceFinder;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UrlContainVideoService) {
            throw new UnexpectedTypeException($constraint, UrlContainVideoService::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if ($this->videoServiceFinder->find($value) === false) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}