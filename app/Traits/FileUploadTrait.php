<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileUploadTrait
{
    /**
     * Store an uploaded file and return its path.
     *
     * @param UploadedFile $file The file to store
     * @param string $disk The storage disk to use (default: 'public')
     * @param string $folder The folder path within the disk
     * @return string The stored file path
     */
    protected function storeFile(
        UploadedFile $file,
        string $disk = 'public',
        string $folder = ''
    ): string {
        $path = $folder ? $folder . '/' . Str::random(20) . '_' . $file->getClientOriginalName()
            : Str::random(20) . '_' . $file->getClientOriginalName();

        return $file->storeAs('', $path, $disk);
    }

    /**
     * Store multiple files and return their paths.
     *
     * @param array $files Array of UploadedFile instances
     * @param string $disk The storage disk to use
     * @param string $folder The folder path within the disk
     * @return array Array of stored file paths
     */
    protected function storeFiles(
        array $files,
        string $disk = 'public',
        string $folder = ''
    ): array {
        return array_map(
            fn(UploadedFile $file) => $this->storeFile($file, $disk, $folder),
            $files
        );
    }

    /**
     * Delete a file from storage.
     *
     * @param string $path The file path to delete
     * @param string $disk The storage disk to use
     * @return bool Whether the deletion was successful
     */
    protected function deleteFile(string $path, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Delete multiple files from storage.
     *
     * @param array $paths Array of file paths to delete
     * @param string $disk The storage disk to use
     * @return array Array of deletion results (path => success boolean)
     */
    protected function deleteFiles(array $paths, string $disk = 'public'): array
    {
        return array_reduce($paths, function (array $results, string $path) use ($disk) {
            $results[$path] = $this->deleteFile($path, $disk);
            return $results;
        }, []);
    }

    /**
     * Replace an existing file with a new one.
     *
     * @param UploadedFile $file The new file
     * @param string $oldPath The path of the file to replace
     * @param string $disk The storage disk to use
     * @param string $folder The folder path within the disk
     * @return string The stored file path
     */
    protected function replaceFile(
        UploadedFile $file,
        string $oldPath,
        string $disk = 'public',
        string $folder = ''
    ): string {
        $this->deleteFile($oldPath, $disk);

        return $this->storeFile($file, $disk, $folder);
    }

    /**
     * Get the URL of a stored file.
     *
     * @param string $path The file path
     * @param string $disk The storage disk to use
     * @return string The file URL
     */
    protected function getFileUrl(string $path, string $disk = 'public'): string
    {
        return Storage::url($path);
    }

    /**
     * Check if a file exists in storage.
     *
     * @param string $path The file path
     * @param string $disk The storage disk to use
     * @return bool Whether the file exists
     */
    protected function fileExists(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->exists($path);
    }

    /**
     * Get the size of a stored file in bytes.
     *
     * @param string $path The file path
     * @param string $disk The storage disk to use
     * @return int|null The file size, or null if it doesn't exist
     */
    protected function getFileSize(string $path, string $disk = 'public'): ?int
    {
        if ($this->fileExists($path, $disk)) {
            return Storage::disk($disk)->size($path);
        }

        return null;
    }
}
