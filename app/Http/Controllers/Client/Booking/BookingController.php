<?php

namespace App\Http\Controllers\Client\Booking;

use App\Http\Requests\Client\Booking\StoreRequest;
use App\Http\Controllers\Controller;
use App\Models\{Booking, BookingItem, Provider};
use App\Http\Resources\BookingResource;
use App\Http\Resources\AdjustableDetailLevelResource;

class BookingController extends Controller
{
    public function create(StoreRequest $request) {
        
        // create the booking
        $booking = Booking::create(array_merge(
            $request->except('service_types'),
            [
                'status' => Booking::STATUS_REQUEST_UNNALOCATED,
                'client_id' => $request->user()->id,
                'staff_id' => 0
            ]
        ));

        // create the booking items
        foreach ($request->service_types as $serviceID) {
            $provider = Provider::findOrFail($request->provider_id);
            $service = $provider->services()->where('service_id', $serviceID)->first();
            $booking->items()->create([
                'services_id' => $service->id,
                'cost' => $service->id,
                'vat' => $service->id,
            ]);
        }

        return response()->json([
            'success' => true,
            'resource' => new BookingResource($booking->fresh(), AdjustableDetailLevelResource::DETAIL_ALL)
        ]);
    }
}
