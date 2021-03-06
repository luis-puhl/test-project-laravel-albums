<?php

namespace App\Http\Middleware\StoreFiles;

use Illuminate\Http\UploadedFile as IlluminateUploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadedFileWrapper {
    public $extension, $storedPath, $originalName, $url;

    // IlluminateUploadedFile
    public $uploadedFile;

    public function __construct(IlluminateUploadedFile $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
        $this->originalName = $uploadedFile->getClientOriginalName();
    }

    public function getExtension()
    {
        if (!$this->extension) {
            $this->extension = $this->uploadedFile->getClientOriginalExtension();
        }
        if (!$this->extension) {
            $this->extension = $this->uploadedFile->extension();
        }
        if (!$this->extension) {
            $this->extension = $this->uploadedFile->guessExtension();
        }
        return $this->extension;
    }

    public function isExtensionValid(array $allowedExtensions)
    {
        if (count($allowedExtensions) > 0) {
            return in_array($this->getExtension(), $allowedExtensions);
        }
        return true;
    }

    public function store($disk = 'public')
    {
        $this->storedPath = $this->uploadedFile->storePublicly('uploads', $disk);
        $this->url = Storage::url($this->storedPath);
        return $this->storedPath;
    }

    public function delete()
    {
        if ($this->storedPath) {
            return Storage::delete($this->storedPath);
        }
        return false;
    }

    /** Passthrough */

    public function getMimeType()
    {
        return $this->uploadedFile->getMimeType();
    }

    public function getSize()
    {
        return $this->uploadedFile->getSize();
    }
}
