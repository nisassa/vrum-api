<?php

namespace App\Http\Requests\Provider;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
