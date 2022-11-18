<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;
use App\Models\{User, Provider};
use App\Http\Requests\Auth\{
    ProviderRegisterRequest,
    ClientRegisterRequest,
    LoginRequest
};
use Illuminate\Support\Facades\Hash;
use App\Notifications\Auth\{
    ProviderRegistered,
    ClientRegistered
};
use ViewberBase\ApiMobileClient;
use ViewberBase\UserLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\AdjustableDetailLevelResource;

class AuthController extends Controller
{
    public function me(Request $request)
    {
        return response()->json([
            'resource' => new UserResource($request->user(), AdjustableDetailLevelResource::DETAIL_ALL)
        ]);
    }

    public function logout(LoginRequest $request)
    {
        // Invalidate returns false if the token has expired
        Auth::logout();

        return response()->json(['resource' => true]);
    }


    public function login(LoginRequest $request)
    {
        $input = $request->all();

        $user = User::where('email', $input['email'])->first();
        if (! $user) {
            return response()->json(['messages' => ['The details you have provided do not match our records.']]);
        }

        $agent = new Agent;

        // Captures what device, browser & os user using.
        UserLogin::create([
            'user_id' => $user->id,
            'device' => $agent->device(),
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
        ]);

        if (app('SdCmsEncryptHelper')->verify($input['password'], $user->password)) {
            $token = Auth::login($user);
        }

        return response()->json(['success' => true, 'token' => $token ?? null]);
    }

    public function registerClient(ClientRegisterRequest $request)
    {
        $input = $request->all();

        $user = User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'line_1' => $input['line_1'] ?? null,
            'line_2' => $input['line_2'] ?? null,
            'city' => $input['city'],
            'county' => $input['county'] ?? null,
            'country' => $input['country'],
            'postcode' => $input['postcode'] ?? null,
            'manager' => 0,
            'type' => User::CLIENT_TYPE,
            'password' => Hash::make($input['password'], [
                'rounds' => 12,
            ])
        ]);

        $user->notify(new ClientRegistered());

        return response()->json(['success' => true]);
    }


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
            'password' => $input['password'] = app('SdCmsEncryptHelper')->encrypt($input['password'])
        ]);

        $user->notify(new ProviderRegistered());

        return response()->json(['success' => true]);
    }
}
