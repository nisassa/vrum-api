<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use App\Listeners\SendPasswordResetLinkToUserEmail;
use App\Models\{
    User,
    Provider,
    UserLogin,
    PasswordReset
};
use App\Http\Requests\Auth\{
    ProviderRegisterRequest,
    ClientRegisterRequest,
    LoginRequest
};

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\Provider\UpdateRequest as UpdateProviderRequest;
use App\Notifications\Auth\{
    ProviderRegistered,
    ClientRegistered
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\AdjustableDetailLevelResource;
use App\Listeners\{CreateWorkingHours, UpdateWorkingHours};

class AuthController extends Controller
{
    public function me(Request $request)
    {
        return response()->json([
            'resource' => new UserResource($request->user(), AdjustableDetailLevelResource::DETAIL_ALL)
        ]);
    }

    public function destroyUser(Request $request)
    {
        $user = $request->user();
        $user->fill(['discard' => true])->save();
        return response()->json([
            'success' => true
        ]);
    }

    public function updateProvider(UpdateProviderRequest $request)
    {
        $user = $request->user();
        $input = $request->validated();
        $businessDays = $request->input('business_days');
        unset($input['business_days']);

        $provider = Provider::where('id', $user->provider_id)->first();
        $provider->fill($input)->save();

        UpdateWorkingHours::dispatch($provider, $businessDays);

        return response()->json([
            'success' => true,
            'resource' => new UserResource(
                User::where('id', $user->id)->with('provider.working_days')->first(),
                AdjustableDetailLevelResource::DETAIL_ALL
            )
        ]);
    }

    public function updateUser(UpdateUserRequest $request)
    {
        $input = $request->validated();
        $businessDays = $request->input('business_days');
        unset($input['business_days']);

        $user = $request->user();

        if (isset($input['password']) && !empty($input['password'])) {
            $input['password'] = app('SdCmsEncryptHelper')->encrypt($input['password']);
        }

        $user->fill($input)->save();

        if (! empty($businessDays)) {
            UpdateWorkingHours::dispatch($user, $businessDays);
        }

        return response()->json([
            'success' => true,
            'resource' => new UserResource($user->refresh(),AdjustableDetailLevelResource::DETAIL_ALL)
        ]);
    }

    public function logout(Request $request)
    {
        // Invalidate returns false if the token has expired
        Auth::logout();

        return response()->json(['resource' => true]);
    }

    public function login(LoginRequest $request)
    {
        $input = $request->validated();

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

            $user = $request->user()->load('provider.working_days');

            $resource = new UserResource($user,AdjustableDetailLevelResource::DETAIL_ALL);
        }

        return response()->json([
            'success' => true,
            'token' => $token ?? null,
            'resource' => $resource ?? null
        ]);
    }

    public function registerClient(ClientRegisterRequest $request)
    {
        $input = $request->validated();
        $location = $request->input('location');
        
        $city = $location['city'] ?? null;
        $country = $location['country'] ?? null;
        $road = $location['road'] ?? null;
        $number = $location['number'] ?? null;
        $latitude = $location['latitude'] ?? null;
        $longitude = $location['longitude'] ?? null;
        
        if ($city) {
            $input['city'] = $city;
        }

        if ($country) {
            $input['country'] = $country;
        }

        if ($road && $number) {
            $input['line_1'] = $road.' '.$number;
        }
        
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
            'password' => $input['password'] = app('SdCmsEncryptHelper')->encrypt($input['password']),
            'lat' => $latitude,
            'long' => $longitude,
        ]);

        $user->notify(new ClientRegistered());

        return response()->json(['success' => true]);
    }

    public function registerProvider(ProviderRegisterRequest $request)
    {
        $input = $request->validated();

        $provider = Provider::create([
            'name' => $input['provider_name'],
            'invoice_email' => $input['email'],
            'booking_by_specialist' => $input['booking_by_specialist'],
            'line_1' => $input['line_1'],
            'line_2' => $input['line_2'] ?? null,
            'city' => $input['city'],
            'county' => $input['county'] ?? null,
            'country' => $input['country'],
            'postcode' => $input['postcode'],
            'type' => $input['type'],
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
            'line_2' => $input['line_2'] ?? null,
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

        CreateWorkingHours::dispatch($provider);
        CreateWorkingHours::dispatch($user);

        return response()->json(['success' => true]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => [
            'required',
            'email',
        ]], [
            'email.exists' => 'If this email matches an account, we will send a reset link to your email.'
        ]);

        try {
            SendPasswordResetLinkToUserEmail::dispatch($request->input('email'));
        } catch(\Throwable $e) {
            \Log::warning($e->getMessage());
        }

        return response()->json(['If this email matches an account, we will send a reset link to your email.']);
    }

    public function reset(Request $request)
    {
        // overwrite default password rules
        $rules = [
            'password' => ['required', 'confirmed', 'string', 'min:5', 'max:255'],
            'email' => ['required', 'email']
        ];

        $this->validate($request, $rules);

        $input = $request->all();

        $passwordReset = PasswordReset::where('token', $input['token'] ?? null)
            ->orderBy('id', 'desc')
            ->first();

        if ($passwordReset) {
            $user = User::where('email', $passwordReset->email);
        }

        if (empty($passwordReset) || empty($user)) {
            return response()->json(['errors' => ['invalid' => 'Password Change Token Invalid']]);
        }

        $tokenExpiresAt = $passwordReset->created_at->setTimezone(config('app.timezone'))->addHour();

        if (empty($user->discard) && ($tokenExpiresAt > Carbon::now())) {
            // Reset password
            $user->update(['password' => app('SdCmsEncryptHelper')->encrypt($input['password'])]);

            // delete the token
            $passwordReset->delete();
        } else {
            return response()->json(['errors' => ['timeout' => 'Password Request Timeout']]);
        }

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return response()->json([
            'success' => true,
        ]);
    }
}
