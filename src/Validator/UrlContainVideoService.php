<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UrlContainVideoService extends Constraint
{
    public $message = 'L\'url n\'est pas prise en charge. Veuillez entrer un lien youtube, dailymotion ou vimeo.';
}