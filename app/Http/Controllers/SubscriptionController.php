<?php
namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
   use ApiResponseTrait;

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'start_date' => 'required|date',
            'subscription_duration' => 'required|in:monthly,3_months,6_months,1_year',
        ]);

        $startDate = Carbon::parse($request->input('start_date'));
        $duration = $request->input('subscription_duration');

        switch ($duration) {
            case 'monthly':
                $endDate = $startDate->copy()->addMonth();
                break;
            case '3_months':
                $endDate = $startDate->copy()->addMonths(3);
                break;
            case '6_months':
                $endDate = $startDate->copy()->addMonths(6);
                break;
            case '1_year':
                $endDate = $startDate->copy()->addYear();
                break;
            default:
                $endDate = $startDate;
                break;
        }

        $subscription = Subscription::create([
            'customer_name' => $request->input('customer_name'),
            'customer_email' => $request->input('customer_email'),
            'start_date' => $request->input('start_date'),
            'end_date' => $endDate->format('Y-m-d'),
            'status' => 'active',
            'subscription_duration' => $duration, 
        ]);

        return $this->apiResponse($subscription, 'Subscription created successfully', 201);
    }

    public function renew(Request $request, $id)
    {
        $request->validate([
            'subscription_duration' => 'required|in:monthly,3_months,6_months,1_year', 
        ]);

        $subscription = Subscription::find($id);

        if (!$subscription) {
            return $this->apiResponse(null, 'Subscription not found', 404);
        }

        $startDate = Carbon::parse($subscription->end_date);
        $duration = $request->input('subscription_duration');

        switch ($duration) {
            case 'monthly':
                $endDate = $startDate->copy()->addMonth();
                break;
            case '3_months':
                $endDate = $startDate->copy()->addMonths(3);
                break;
            case '6_months':
                $endDate = $startDate->copy()->addMonths(6);
                break;
            case '1_year':
                $endDate = $startDate->copy()->addYear();
                break;
            default:
                $endDate = $startDate;
                break;
        }

        $subscription->end_date = $endDate->format('Y-m-d');
        $subscription->subscription_duration = $request->input('subscription_duration');
        $subscription->status = 'active'; 
        $subscription->save();

        return $this->apiResponse($subscription, 'Subscription renewed successfully');
    }


    public function suspend(Request $request, $id)
    {
        $request->validate([
            'suspension_reason' => 'required|string',
        ]);

        $subscription = Subscription::find($id);

        if (!$subscription) {
            return $this->apiResponse(null, 'Subscription not found', 404);
        }

        $subscription->status = 'suspended';
        $subscription->suspension_reason = $request->input('suspension_reason');
        $subscription->save();

        return $this->apiResponse($subscription, 'Subscription suspended successfully');
    }

       public function index()
    {        $subscriptions = Subscription::all();
        return $this->apiResponse($subscriptions, 'Subscriptions retrieved successfully');
    }

  
    public function show($id)
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return $this->apiResponse(null, 'Subscription not found', 404);
        }

        return $this->apiResponse($subscription, 'Subscription retrieved successfully');
    }
}
