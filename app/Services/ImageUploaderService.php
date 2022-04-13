<?php

namespace App\Services;


use Illuminate\Http\UploadedFile;

class ImageUploaderService
{

    /**
     * Save image to public path. Note that you need make storage link in your public path
     *
     * @param UploadedFile $image
     * @return string
     */
    public function saveImageAndGetPath(UploadedFile $image): string{

        $filenameWithExtension = $image->getClientOriginalName();

        $fileName = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

        $extension = $image->getClientOriginalExtension();

        $fileNameToStore = "images/" . $fileName . "_" . time().".".$extension;

        $image->storeAs('public', $fileNameToStore);

        return url('storage/' . $fileNameToStore);
    }

}
