<?php

namespace App\Listener\Doctrine;

use App\Entity\Image;
use App\Service\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

class ImageListener
{
    /** @var ContainerInterface $container */
    private $container;

    /** @var FileUploader $fileUploader */
    private $fileUploader;

    /** @var Filesystem $filesystem */
    private $filesystem;

    public function __construct(FileUploader $fileUploader, Filesystem $filesystem, ContainerInterface $container)
    {
        $this->container = $container;
        $this->fileUploader = $fileUploader;
        $this->filesystem = $filesystem;
    }

    public function prePersist(Image $image, LifecycleEventArgs $args)
    {
        if ($image->getFile() === null) {
            return;
        }

        $image->setFilename(
            $this->fileUploader->upload(
                $image->getFile()
            )
        );
    }

    public function preRemove(Image $image, LifecycleEventArgs $args)
    {
        // TODO: delete image when delete a trick
        $this->filesystem->remove($this->container->getParameter('images_directory') . '/' . $image->getFilename());
    }
}