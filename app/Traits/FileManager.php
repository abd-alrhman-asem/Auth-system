<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

trait FileManager
{
    /**
     * Store a file with a customized name, extension, disk, and path.
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string $disk
     * @return string
     */
    public function storeFile(UploadedFile $file,  string $disk = 'public' , string $path= null): string
    {
        $timestamp = Carbon::now()->format('YmdHis'); // Get current date and time
        $uniqueString = Str::random(10); // Generate a unique random string
        $name = $timestamp . '_' . $uniqueString;
        $ext = $file->guessExtension();
        $fileNameWithExtension = $name . '.' . $ext;

        return $file->storeAs($path, $fileNameWithExtension, $disk);
    }

    /**
     * Delete a file.
     *
     * @param string $filePath
     * @param string $disk
     * @return bool
     */
    public function deleteFile(string $filePath, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->delete($filePath);
        }
        return false;
    }

    /**
     * Check if a file exists.
     *
     * @param string $filePath
     * @param string $disk
     * @return bool
     */
    public function fileExists(string $filePath, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->exists($filePath);
    }

    /**
     * Get the URL of a file.
     *
     * @param string $filePath
     * @param string $disk
     * @return string
     */
    public function getFileUrl(string $filePath, string $disk = 'public'): string
    {
        return Storage::disk($disk)->url($filePath);
    }

    /**
     * Get the contents of a file.
     *
     * @param string $filePath
     * @param string $disk
     * @return ?string
     */
    public function getFileContents(string $filePath, string $disk = 'public'): ?string
    {
        if ($this->fileExists($filePath, $disk)) {
            return Storage::disk($disk)->get($filePath);
        }
        return null;
    }

    /**
     * Move a file.
     *
     * @param string $oldPath
     * @param string $newPath
     * @param string $disk
     * @return bool
     */
    public function moveFile(string $oldPath, string $newPath, string $disk = 'public'): bool
    {
        if ($this->fileExists($oldPath, $disk)) {
            return Storage::disk($disk)->move($oldPath, $newPath);
        }
        return false;
    }

    /**
     * Copy a file.
     *
     * @param string $oldPath
     * @param string $newPath
     * @param string $disk
     * @return bool
     */
    public function copyFile(string $oldPath, string $newPath, string $disk = 'public'): bool
    {
        if ($this->fileExists($oldPath, $disk)) {
            return Storage::disk($disk)->copy($oldPath, $newPath);
        }

        return false;
    }
}
