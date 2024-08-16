<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SportImage;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SportImageController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $images = SportImage::all();
        return $this->apiResponse($images, 'Images retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'image' => 'required|image|max:2048',
        ]);

        
        // $path = $request->file('image')->store('sport_images', 'public');
        
        $path=$this->saveImage($request->image,'images/sport');

        $image = SportImage::create([
            'sport_id' => $request->sport_id,
            'image_path' => $path,
        ]);

        return $this->apiResponse($image, 'Image created successfully', 201);
    }


    public function show(SportImage $sportImage)
    {
        return $this->apiResponse($sportImage, 'Image retrieved successfully');
    }

    public function update(Request $request, SportImage $sportImage)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($sportImage->image_path);
            $path = $request->file('image')->store('sport_images', 'public');
            $sportImage->update(['image_path' => $path]);
        }

        return $this->apiResponse($sportImage, 'Image updated successfully');
    }

    public function destroy(SportImage $sportImage)
    {
        Storage::disk('public')->delete($sportImage->image_path);
        $sportImage->delete();
        return $this->apiResponse(null, 'Image deleted successfully', 204);
    }}
