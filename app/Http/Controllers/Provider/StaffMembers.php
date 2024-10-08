<?php

namespace App\Http\Controllers\Provider;

use App\Http\Requests\Provider\IndexRequest as ProviderIndexRequest;
use App\Http\Requests\Provider\StaffMember\StoreRequest as StoreStaffMemberRequest;
use App\Http\Requests\Provider\StaffMember\UpdateRequest as UpdateRequestStaffMemberRequest;
use App\Http\Requests\Provider\StaffMember\GetRequest as GetStaffMemberRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdjustableDetailLevelResource;
use App\Http\Resources\UserResource;
use App\Listeners\CreateWorkingHours;
use App\Listeners\UpdateWorkingHours;
use App\Models\ServiceType;
use App\Models\User;

class StaffMembers extends Controller
{
    public function delete(ProviderIndexRequest $request, User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function updateMember(UpdateRequestStaffMemberRequest $request, User $user) {

        if ($user->provider_id !== $request->user()->provider_id)  {
            abort(403);
        }

        $input = $request->validated();
        $businessDays = $request->input('business_days');
        unset($input['business_days']);

        $user->fill($input);
        $user->save();

        UpdateWorkingHours::dispatch($user, $businessDays);

        return response()->json([
            'success' => true
        ]);
    }

    public function getUser(GetStaffMemberRequest $request, User $user) {
        if ($request->user()->provider_id !== $user->provider_id) {
            abort(403, 'Unauthorised');
        }

        return response()->json([
            'success' => true,
            'resource' => new UserResource(
                $user->refresh()->load('service_types'), 
                AdjustableDetailLevelResource::DETAIL_ALL
            )
        ]);
    }

    public function paginateStaff(ProviderIndexRequest $request) {

        $searchQuery = $request->input('q');

        $users = User::where('provider_id', $request->user()->provider_id);

        if (! empty($searchQuery)) {
            $users
                ->where(function ($query) use ($searchQuery) {
                    $query
                        ->where(\DB::raw('CONCAT_WS(" ", `first_name`, `last_name`)'), 'like', '%' . $searchQuery . '%')
                        ->orWhere('first_name', 'like', '%' . $searchQuery . '%')
                        ->orWhere('last_name', 'like', '%' . $searchQuery . '%')
                        ->orWhere('email', 'like', '%' . $searchQuery . '%')
                        ->orWhere('phone', 'like', '%' . $searchQuery . '%');
                });
        }
        
        return response()->json([
            'success' => true,
            'users' => $users->paginate()
        ]);
    }

    public function storeMember(StoreStaffMemberRequest $request) {

        $input = $request->validated();
        $user = User::create(array_merge($input, [
            'provider_id' => $request->user()->provider_id,
            'manager' => 0,
            'password' => $input['password'] = app('SdCmsEncryptHelper')->encrypt($input['password']),
            'type' => User::SERVICE_PROVIDER_STAFF_TYPE
        ]));

        CreateWorkingHours::dispatch($user);

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
