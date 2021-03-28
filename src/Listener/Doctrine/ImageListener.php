<?php

namespace App\Listener\Doctrine;

use App\Entity\Image;
use App\Service\FileUploader;
use Symfony\Component\Filesystem\Filesystem;

class ImageListener
{
    /** @var FileUploader $fileUploader */
    private $fileUploader;

    /** @var Filesystem $filesystem */
    private $filesystem;

    public function __construct(FileUploader $fileUploader, Filesystem $filesystem)
    {
        $this->fileUploader = $fileUploader;
        $this->filesystem = $filesystem;
    }

    public function prePersist(Image $image)
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

    public function postRemove(Image $image)
    {
        $this->fileUploader->remove($image->getFilename());
    }
}
