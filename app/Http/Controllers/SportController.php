<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;


class SportController extends Controller
{
   use ApiResponseTrait;

    public function index()
    {
        $sports = Sport::all();
        return $this->apiResponse($sports,'ok',200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schedule' => 'required|json',
        ]);

        $sport = Sport::create($request->all());
        if ($sport) {
        return $this->apiResponse($sport, 'Sport created successfully', 201);
        }
        return $this->apiResponse(null, 'Sport not save ', 400);

    }

    public function show(Sport $sport)
    {
        if($sport){
            return $this->apiResponse($sport , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the sport not found' ,404);
    }

    public function update(Request $request, Sport $sport)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schedule' => 'required|json',
        ]);

        $sport->update($request->all());
        return $this->apiResponse($sport, 'Sport updated successfully');
    }

    public function destroy(Sport $sport)
    {
        $sport->delete();
        return $this->apiResponse(null, 'Sport deleted successfully', 204);
    }
}
