<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class FacilityController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $facilities = Facility::with('sports')->get();
        return $this->apiResponse($facilities, 'Facilities retrieved successfully', 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sports' => 'nullable|array',
            'sports.*' => 'exists:sports,id',
        ]);

        $facility = Facility::create($validated);

        if ($request->has('sports')) {
            $facility->sports()->sync($validated['sports']);
        }

        $facility->load('sports');
        return $this->apiResponse($facility, 'Facility created successfully', 201);
    }

    public function show($id)
    {
        $facility = Facility::with('sports')->find($id);

        if (!$facility) {
            return $this->apiResponse(null, 'Facility not found', 404);
        }

        return $this->apiResponse($facility, 'Facility retrieved successfully', 200);
    }

    public function update(Request $request, $id)
    {
        $facility = Facility::find($id);

        if (!$facility) {
            return $this->apiResponse(null, 'Facility not found', 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sports' => 'nullable|array',
            'sports.*' => 'exists:sports,id',
        ]);

        $facility->update($validated);

        if ($request->has('sports')) {
            $facility->sports()->sync($validated['sports']);
        }

        $facility->load('sports');
        return $this->apiResponse($facility, 'Facility updated successfully', 200);
    }

    public function destroy($id)
    {
        $facility = Facility::find($id);

        if (!$facility) {
            return $this->apiResponse(null, 'Facility not found', 404);
        }

        $facility->delete($id);
        if($facility)
        return $this->apiResponse(null ,'the facility delete ',200);
    }
}
