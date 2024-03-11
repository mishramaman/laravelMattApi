<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'images' => 'required|array', 
           // 'day_id'=>'required',
            'id'=>'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'duration' => 'required',
            'distance' => 'required',
        ]);

        
        $newImage = new Image();
        $newImage->id = $request->id;
        // $newImage->day = $request->day;
        $newImage->startTime = $request->startTime;
        $newImage->endTime = $request->endTime;
        $newImage->duration = $request->duration;
        $newImage->distance = $request->distance;

        $uploadedPaths = [];

        foreach ($request->input('images') as $imageData) {
            $base64String = substr($imageData, strpos($imageData, ',') + 1);
            $decodedImageData = base64_decode($base64String);

        //     $directory = 'public/images/'.$request->input('id');
        //     if (!Storage::exists($directory)) {
        //     Storage::makeDirectory($directory);
        // }
            $folderPath = 'MobilityImages/Mobility-' . $request->id.'/Day-'.$request->day;
            $fileName = 'Mobility-Request' . time() . '_' . uniqid() . '.png';
            if(Storage::disk('public')->put($folderPath . '/' . $fileName, $decodedImageData)){
                $imagePath = $folderPath . '/' . $fileName;
            } else {
                $imagePath = "";
            }
            $uploadedPaths[] = $imagePath;
        }
        $newImage->path = implode(',', $uploadedPaths); 
        $newImage->save();

        return response()->json(['message' => 'Images uploaded successfully', 'paths' => $uploadedPaths], 200);
    }
}