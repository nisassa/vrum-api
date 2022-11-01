<?php

namespace App\Http\Controllers;

use App\Models\{User, Provider};

use App\Http\Requests\Auth\ProviderRegisterRequest;

class AuthController extends Controller
{
    public function registerProvider(ProviderRegisterRequest $request)
    {
        $input = $request->all();

        $provider = Provider::create([
            'name' => $input['provider_name'],
            'invoice_email' => $input['email'],
            'booking_by_specialist' => $input['booking_by_specialist'],
            'booking_approved_by_provider' => ! (bool) $input['booking_by_specialist'],
            'line_1' => $input['line_1'],
            'line_2' => $input['line_2'],
            'city' => $input['city'],
            'county' => $input['county'] ?? null,
            'country' => $input['country'],
            'postcode' => $input['postcode'],
        ]);

        if (! $provider) {
            return response()->json(['errors' => ['An error occurred! Please contact support.']], 403);
        }

        $user = User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'line_1' => $input['line_1'],
            'line_2' => $input['line_2'],
            'city' => $input['city'],
            'county' => $input['county'] ?? null,
            'country' => $input['country'],
            'postcode' => $input['postcode'],
            'provider_id' => $provider->id,
            'manager' => 1,
            'type' => User::SERVICE_PROVIDER_TYPE,
            'password' => $input['password'],
        ]);

        return response()->json(['success' => true, 'use_idr' => $user->id]);
    }
}
