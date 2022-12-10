<?php

namespace App\Http\Requests\Provider\Service;

use App\Http\Requests\Provider\IndexRequest;
use App\Models\Provider;
use App\Models\User;

class GetRequest extends IndexRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        if (! in_array($user->type, [User::SERVICE_PROVIDER_TYPE, User::SERVICE_PROVIDER_STAFF_TYPE])) {
            // User must be a provider
            return false;
        }

        if (! Provider::where('id',$user->provider_id )->exists()) {
            //  Provider must be valid
            return false;
        }

        return true;
    }
}
