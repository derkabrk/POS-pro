<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HasUploader
{
    private function upload(Request $request, $input, $oldFile = null, $disk = null)
    {
        $file = $request->file($input);
        $ext = $file->getClientOriginalExtension();
        $filename = now()->timestamp.'-'.rand(1, 1000).'.'.$ext;

        $path = 'uploads/' . date('y') . '/' . date('m') . '/';
        $filePath = $path.$filename;

        if($oldFile) {
            if (file_exists($oldFile)) {
                Storage::delete($oldFile);
            }
        }

        Storage::disk($disk ?? config('filesystems.default'))->put($filePath, file_get_contents($file));
        return $filePath;
    }

    private function uploadWithFileName(Request $request, $input, $oldFile = null, $disk = null)
    {
        $file = $request->file($input);
        $filename = $file->getClientOriginalName();

        $path = 'files/';
        $filePath = $path.$filename;

        if($oldFile) {
            if (file_exists($oldFile)) {
                Storage::delete($oldFile);
            }
        }

        Storage::disk($disk ?? config('filesystems.default'))->put($filePath, file_get_contents($file));
        return $filePath;
    }

    private function multipleUpload(Request $request, $input, $oldFiles = [], $disk = null)
    {
         $uploadedFiles = [];

        foreach ($request->file($input) as $file) {
            $ext = $file->getClientOriginalExtension();
            $filename = now()->timestamp . '_' . uniqid() . '.' . $ext;

            $path = 'uploads/' . date('y') . '/' . date('m') . '/';
            $filePath = $path . $filename;

            foreach ($oldFiles as $oldFile) {
                if (file_exists($oldFile)) {
                    Storage::delete($oldFile);
                }
            }

            Storage::disk($disk ?? config('filesystems.default'))->put($filePath, file_get_contents($file));
            $uploadedFiles[] = $filePath;
        }

        return $uploadedFiles;
    }

}
