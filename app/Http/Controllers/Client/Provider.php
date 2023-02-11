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
        if (! empty($searchQuery)) {
            $providers
                ->where(function ($query) use ($searchQuery) {
                    $query
                        ->where('name', 'like', '%' . $searchQuery . '%')
                        ->orWhere('line_1', 'like', '%' . $searchQuery . '%')
                        ->orWhere('city', 'like', '%' . $searchQuery . '%');
                });
        }
        
        return response()->json([
            'success' => true,
            'users' => $providers->paginate()
        ]);
    }


    public function listCities(Request $request)
    {
        $citie = \DB::table('providers')
            ->distinct()
            ->select('city')
            ->orderBy('city', 'ASC')
            ->get()
            ->toArray();
        
        return response()->json([
            'success' => true,
            'cities' => $citie
        ]);
    }
}
