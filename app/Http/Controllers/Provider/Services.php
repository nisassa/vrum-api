<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdjustableDetailLevelResource;
use App\Http\Resources\ServiceTypeResource;
use App\Models\{ ServiceType, Provider, ProviderServices };
use App\Http\Requests\Provider\IndexRequest as ProviderIndexRequest;
use App\Http\Requests\Provider\Service\CreateRequest as CreateProviderServiceRequest;
use App\Http\Requests\Provider\Service\UpdatedRequest as UpdateProviderServiceRequest;
use App\Http\Requests\Provider\Service\GetRequest as GetProviderServiceRequest;

class Services extends Controller
{   
    public function getService(GetProviderServiceRequest $request, ServiceType $service) {
        if ($request->user()->provider_id !== $service->provider_id) {
            abort(403, 'Unauthorised');
        }

        return response()->json([
            'success' => true,
            'resource' => new ServiceTypeResource($service->refresh()->load('category'), AdjustableDetailLevelResource::DETAIL_ALL)
        ]);
    }


    public function getMyServices(GetProviderServiceRequest $request) {
        return response()->json([
            'success' => true,
            'resource' => ServiceTypeResource::collection($request->user()->provider->services)
        ]);
    }

    public function paginateServices(ProviderIndexRequest $request)
    {
        $services = ServiceType::whereIn('provider_id', [$request->user()->provider_id, 0])
            ->with("provider", "category")
            ->paginate(30);

        return response()->json([
            'resource' => $services
        ]);
    }

    public function delete(ProviderIndexRequest $request, ServiceType $service) {

        $service->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function update(UpdateProviderServiceRequest $request) {

        $service = ProviderServices::where([
            ['provider_id', '=', $request->user()->provider_id],
            ['service_id', '=', $request->service_id],
        ])->firstOrFail();

        $input = $request->only(['vat', 'cost']);

        $service->fill($input);
        $service->save();

        return response()->json([
            'success' => true
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


    public function toggleServiceType(ProviderIndexRequest $request, Provider $provider, ServiceType $service)  {

        if ($provider->services()->where('service_id', $service->id)->exists()) {
            $provider->services()->detach($service->id);
        } else {
            $provider->services()->attach($service->id);
        }
        
        return response()->json([
            'success' => true
        ]);
    }
}
