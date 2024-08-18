<?php

namespace App\Http\Controllers;

use App\Models\SportVideo;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Storage;

class SportVideoController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $videos = SportVideo::all();
        return $this->apiResponse($videos, 'ok', 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'video' => 'required|mimes:mp4,mov,avi|max:20000',
        ]);

        $path = $request->file('video')->store('sport_videos', 'public');
        $video = SportVideo::create([
            'sport_id' => $request->sport_id,
            'video_path' => $path,
        ]);

        if ($video) {
            return $this->apiResponse($video, 'Video uploaded successfully', 201);
        }
        return $this->apiResponse(null, 'Video not uploaded', 400);
    }

    public function show($id)
    {
        $sportVideo = SportVideo::find($id);

        if ($sportVideo) {
            return $this->apiResponse($sportVideo, 'Video retrieved successfully', 200);
        }

        return $this->apiResponse(null, 'Video not found', 404);
    }

    public function update(Request $request, $id)
    {
        $sportVideo = SportVideo::find($id);

        if (!$sportVideo) {
            return $this->apiResponse(null, 'Video not found', 404);
        }

        if ($request->hasFile('video')) {
            Storage::disk('public')->delete($sportVideo->video_path);
            $path = $request->file('video')->store('sport_videos', 'public');
            $sportVideo->update(['video_path' => $path]);
        }

        return $this->apiResponse($sportVideo, 'Video updated successfully', 200);
    }

    public function destroy($id)
    {
        $sportVideo = SportVideo::find($id);

        if (!$sportVideo) {
            return $this->apiResponse(null, 'Video not found', 404);
        }

        Storage::disk('public')->delete($sportVideo->video_path);
        $sportVideo->delete();

        return $this->apiResponse(null, 'Video deleted successfully', 200);
    }
}

