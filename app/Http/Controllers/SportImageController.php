<?php

namespace App\Http\Controllers;

use App\Models\SportImage;
use App\Models\Sport;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Storage;

class SportImageController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $images = SportImage::all();
        return $this->apiResponse($images, 'ok', 200);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'sport_id' => 'required|exists:sports,id',
    //         'image' => 'required|image|max:2048',
    //     ]);

    //     // $path = $request->file('image')->store('sport_images', 'public');
    //     $path=$this->saveImage($request->image,'images/sport');

    //     $image = SportImage::create([
    //         'sport_id' => $request->sport_id,
    //         'image_path' => $path,
    //     ]);

    //     if ($image) {
    //         return $this->apiResponse($image, 'Image uploaded successfully', 201);
    //     }
    //     return $this->apiResponse(null, 'Image not uploaded', 400);
    // }

    public function store(Request $request, $sportId)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $sport = Sport::find($sportId);
        if (!$sport) {
            return $this->apiResponse(null, 'Sport not found', 404);
        }

        try {
            $path=$this->saveImage($request->image,'images/sport');

            if (!$path) {
                return $this->apiResponse(null, 'Failed to store image', 500);
            }

            $image = SportImage::create([
                'sport_id' => $sportId,
                'image_path' => $path,
            ]);

            if (!$image) {
                return $this->apiResponse(null, 'Failed to create image record', 500);
            }

            return $this->apiResponse($image, 'Image created successfully', 201);

        } catch (\Exception $e) {
            
            return $this->apiResponse(null, 'An error occurred while storing the image', 500);
        }
    }

    public function show($id)
    {
        $sportImage = SportImage::find($id);

        if ($sportImage) {
            return $this->apiResponse($sportImage, 'Image retrieved successfully', 200);
        }

        return $this->apiResponse(null, 'Image not found', 404);
    }

    public function update(Request $request, $id)
    {
        $sportImage = SportImage::find($id);

        if (!$sportImage) {
            return $this->apiResponse(null, 'Image not found', 404);
        }

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($sportImage->image_path);
            $path=$this->saveImage($request->image,'images/sport');
            $sportImage->update(['image_path' => $path]);
        }

        return $this->apiResponse($sportImage, 'Image updated successfully', 200);
    }

    public function destroy($id)
    {
        $sportImage = SportImage::find($id);

        if (!$sportImage) {
            return $this->apiResponse(null, 'Image not found', 404);
        }

        Storage::disk('public')->delete($sportImage->image_path);
        $sportImage->delete();

        return $this->apiResponse(null, 'Image deleted successfully', 200);
    }

    public function imagesBySport($sportId)
    {
        $sport = Sport::find($sportId);

        if (!$sport) {
            return $this->apiResponse(null, 'Sport not found', 404);
        }

        $images = $sport->images; 
        if ($images->isEmpty()) {
            return $this->apiResponse(null, 'No images found for this sport', 404);
        }
        return $this->apiResponse($images, 'Images retrieved successfully', 200);
    }
}
