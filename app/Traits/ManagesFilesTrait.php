<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ManagesFilesTrait
{

    public function uploadFile($file, ?string $existingFilePath = null, bool $unique = false): ?string
    {
        if (!$file) {
            return null;
        }

        if ($unique && $existingFilePath) {
            $this->deleteFile($existingFilePath);
        }

        $fileName = $this->generateFileSlug($file->getClientOriginalName(), $file->extension());

        return $file->storeAs($this->filePath, $fileName, 'public');
    }

    public function deleteFile(string $filePath): bool
    {
        return Storage::disk('public')->delete($filePath);
    }

    protected function generateFileSlug(string $fileName, string $extension): string
    {
        return Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . time() . '.' . $extension;
    }

    public function getFileUrl(null|string $filePath): null|string
    {
        if (!$filePath) {
            return null;
        }

        return Storage::disk('public')->url($filePath);
    }
}
