<?php

namespace App\Services\Storage;

use Core\UseCase\Shared\Interfaces\FileStorageInterface;
use Illuminate\Http\UploadedFile;
use Storage;

class FileStorage implements FileStorageInterface
{

    public function store(string $path, array $file): string
    {
        $content = $this->convertToLaravelFile($file);
        $pathS3 = Storage::disk('s3')->put("$path", $content);
        return Storage::disk('s3')->url($pathS3);
    }

    public function delete(string $path): bool
    {
        Storage::delete($path);
    }

    protected function convertToLaravelFile(array $file): UploadedFile
    {
        return new UploadedFile(
            path: $file['tmp_name'],
            originalName: $file['name'],
            mimeType: $file['type'],
            error: $file['error']
        );
    }

}
