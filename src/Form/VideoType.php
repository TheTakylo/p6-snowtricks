<?php

namespace App\Form;

use App\Entity\Video;
use App\Listener\AddUrlForVideoNonMappedDataSubscriber;
use App\Validator\UrlContainVideoService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', UrlType::class, [
                'label'       => false,
                'constraints' => [
                    new UrlContainVideoService()
                ]
            ])
            ->addEventSubscriber(new AddUrlForVideoNonMappedDataSubscriber);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
