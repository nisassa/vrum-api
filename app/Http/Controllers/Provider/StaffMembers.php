<?php

namespace App\Http\Controllers\Provider;

use App\Http\Requests\Provider\IndexRequest as ProviderIndexRequest;
use App\Http\Requests\Provider\StaffMember\StoreRequest as StoreStaffMemberRequest;
use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use App\Models\User;

class StaffMembers extends Controller
{
    public function storeMember(StoreStaffMemberRequest $request) {

        $input = $request->validated();
        User::create(array_merge($input, [
            'provider_id' => $request->user()->provider_id,
            'manager' => 0,
            'password' => $input['password'] = app('SdCmsEncryptHelper')->encrypt($input['password']),
            'type' => User::SERVICE_PROVIDER_STAFF_TYPE
        ]));

        return response()->json([
            'success' => true
        ]);
    }

    public function toggleServiceType(ProviderIndexRequest $request, User $user, ServiceType $service)  {

        if ($user->service_types()->where('service_type_id', $service->id)->exists()) {
            $user->service_types()->detach($service->id);
        } else {
            $user->service_types()->attach($service->id);
        }

        return response()->json([
            'success' => true
        ]);
    }
}
