<?php
/**
 * Created by PhpStorm.
 * User: cipfahim
 * Date: 9/24/18
 * Time: 11:15 PM
 */

namespace App\Traits;

use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait FileHandler
{
    protected $fileName;

    public function uploadFile($file, $location, $namePrefix, $oldFile = null)
    {
        if (isset($file)) {
//            make unique name for file
            $currentDate = Carbon::now()->toDateString();
            $this->fileName  = $namePrefix.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();

//            delete existing image if exist
            $this->deleteFile($oldFile, $location);

//          save or do whatever you like
            Storage::disk('public')->putFileAs($location.'/', $file, $this->fileName);
        } else {
            if (isset($oldFile)) {
                $this->fileName = $oldFile;
            } else {
                $this->fileName = null;
            }
        }
    }
    public function uploadImage($file, $location, $namePrefix, $width, $height, $oldFile = null)
    {
        if (isset($file)) {
//            make unipue name for image
            $currentDate = Carbon::now()->toDateString();
            $this->fileName  = $namePrefix.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();
//            delete existing image if exist
            $this->deleteFile($oldFile, $location);

//            resize the image
            $img = Image::make($file)->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
//            save the img on storage
            Storage::disk('public')->put($location.'/'.$this->fileName, $img);
        } else {
            if (isset($oldFile)) {
                $this->fileName = $oldFile;
            } else {
                $this->fileName = "default.png";
            }
        }
    }

    public function deleteFile($file = null, $location = null)
    {
        $exists = Storage::disk('public')->exists($location.'/'.$file);
        if ($exists && $file != 'default.png') {
            Storage::disk('public')->delete($location.'/'.$file);
        }
    }
}
