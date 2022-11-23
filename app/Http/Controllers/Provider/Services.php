<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdjustableDetailLevelResource;
use App\Http\Resources\ServiceTypeResource;
use App\Models\{
    ServiceType,
};
use App\Http\Requests\Providers\IndexRequest as ProviderIndexRequest;

class Services extends Controller
{
    public function getProviderServices(ProviderIndexRequest  $request)
    {
        $services = ServiceType::where('provider_id', $request->user()->provider_id)
            ->with("provider")
            ->get();

        return response()->json([
            'resource' => ServiceTypeResource::collection($services, AdjustableDetailLevelResource::DETAIL_ALL)
        ]);
    }
}
