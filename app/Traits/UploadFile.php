<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait UploadFile
{
    public function newImage($path,$request,$image_name = null)
    {
        if($request->file('image'))
        {
            $this->removeFile($path,$image_name);
            $image = request()->file('image');
            $image_name = uniqid('',true) . $image->getClientOriginalName();
            $image->move(public_path($path),$image_name);
        }
        return $image_name;
    }

    public function removeFile($path,$file_name)
    {
        if(File::exists(public_path($path . '/' . $file_name)))
        {
            File::delete(public_path($path . '/' . $file_name));
        }
    }
}
