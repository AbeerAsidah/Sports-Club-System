<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Sport;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class RoomController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $rooms = Room::with('sport')->get(); 
        return $this->apiResponse($rooms, 'Rooms retrieved successfully',200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $room = Room::create($request->all());

        return $this->apiResponse($room, 'Room created successfully', 201);
    }

    public function show($id)
    {
        $room = Room::with('sport')->find($id);

        if (!$room) {
            return $this->apiResponse(null, 'Room not found', 404);
        }

        return $this->apiResponse($room, 'Room retrieved successfully',200);
    }

    public function update(Request $request, $id)
    {

        $room = Room::find($id);

        if (!$room) {
            return $this->apiResponse(null, 'Room not found', 404);
        }

        $room->update($request->all());

        return $this->apiResponse($room, 'Room updated successfully',200);
    }

    public function destroy($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return $this->apiResponse(null, 'Room not found', 404);
        }

        $room->delete();

        return $this->apiResponse(null, 'Room deleted successfully', 200);
    }

    public function roomsBySport($sportId)
    {
        $sport = Sport::find($sportId);
        if (!$sport) {
            return $this->apiResponse(null, 'Sport not found', 404);
        }

        $rooms = $sport->rooms;

        if ($rooms->isEmpty()) {
            return $this->apiResponse(null, 'No rooms found for this sport', 404);
        }
        return $this->apiResponse($rooms, 'Rooms retrieved successfully', 200);
    }
}
