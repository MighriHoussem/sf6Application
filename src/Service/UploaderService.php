<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

//Service used to upload files to public -> images
class UploaderService
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function uploadFile(UploadedFile $uploadedFile, string $targetDirectory): string|Exception
    {
        // this condition is needed because the 'brochure' field is not required
        // so the PDF file must be processed only when a file is uploaded
        if ($uploadedFile) {
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $uploadedFile->move(
                    $targetDirectory,
                    $newFilename
                );
                return $newFilename;
            } catch (FileException $e) {
                throw $e;
                // ... handle exception if something happens during file upload
            }
        }
    }
}
