<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provider as ProviderModel;

class Provider extends Controller
{
    public function searchProviders(Request $request)
    {
        $searchQuery = $request->input('q');
        
        $providers = ProviderModel::query();
        dd($providers->get());

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
}
