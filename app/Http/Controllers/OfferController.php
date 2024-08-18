<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OfferController extends Controller
{

    use ApiResponseTrait;
  
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'type' => 'required|in:fixed,percentage',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $offer = Offer::create($request->all());

        return $this->apiResponse($offer, 'Offer created successfully', 201);
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|string',
            'discount_percentage' => 'sometimes|numeric|min:0|max:100',
            'type' => 'sometimes|in:fixed,percentage',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
        ]);

        $offer = Offer::find($id);

        if (!$offer) {
            return $this->apiResponse(null, 'Offer not found', 404);
        }

        $offer->update($request->all());

        return $this->apiResponse($offer, 'Offer updated successfully');
    }

   
    public function destroy($id)
    {
        $offer = Offer::find($id);

        if (!$offer) {
            return $this->apiResponse(null, 'Offer not found', 404);
        }

        $offer->delete();

        return $this->apiResponse(null, 'Offer deleted successfully');
    }

   
    public function index()
    {
        $offers = Offer::all();
        return $this->apiResponse($offers, 'Offers retrieved successfully');
    }

     public function show($id)
    {
        $offer = Offer::find($id);

        if (!$offer) {
            return $this->apiResponse(null, 'Offer not found', 404);
        }

        return $this->apiResponse($offer, 'Offer retrieved successfully');
    }
}
