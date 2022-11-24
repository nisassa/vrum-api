<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdjustableDetailLevelResource;
use App\Http\Resources\ServiceTypeResource;
use App\Models\{
    ServiceType,
};
use App\Http\Requests\Provider\IndexRequest as ProviderIndexRequest;
use App\Http\Requests\Provider\Service\CreateRequest as CreateProviderServiceRequest;

class Services extends Controller
{
    public function getProviderServices(ProviderIndexRequest  $request)
    {
        $services = ServiceType::whereIn('provider_id', [$request->user()->provider_id, 0])
            ->with("provider")
            ->get();

        return response()->json([
            'resource' => ServiceTypeResource::collection($services, AdjustableDetailLevelResource::DETAIL_ALL)
        ]);
    }

    public function createService(CreateProviderServiceRequest $request) {

        ServiceType::create(array_merge($request->validated(), [
            'provider_id' => $request->user()->provider_id,
        ]));

        return response()->json([
            'success' => true
        ]);
    }

    public function updateService(CreateProviderServiceRequest $request, ServiceType $serviceType) {

        $serviceType->fill(array_merge($request->validated(), [
            'provider_id' => $request->user()->provider_id,
        ]))->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function toggleDisplay(ProviderIndexRequest $request, ServiceType $serviceType) {
        // verify owner
        if ($serviceType->provider_id !== $request->user()->provider_id) {
            abort(403, 'not allowed');
        }

        $serviceType->display = !$serviceType->display;
        $serviceType->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function destroyService(ProviderIndexRequest $request, ServiceType $serviceType) {
        // verify owner
        if ($serviceType->provider_id !== $request->user()->provider_id) {
            abort(403, 'not allowed');
        }

        $serviceType->discard = 1;
        $serviceType->save();

        return response()->json([
            'success' => true
        ]);
    }
}
