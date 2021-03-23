<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    /** @var string $targetDirectory */
    private $targetDirectory;

    /** @var SluggerInterface $slugger */
    private $slugger;

    /** @var Filesystem $filesystem */
    private $filesystem;

    public function __construct($targetDirectory, SluggerInterface $slugger, Filesystem $filesystem)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
        $this->filesystem = $filesystem;
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    public function remove($filename): void
    {
        $this->filesystem->remove($this->getTargetDirectory() . DIRECTORY_SEPARATOR . $filename);
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}