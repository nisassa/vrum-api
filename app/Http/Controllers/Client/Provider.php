<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provider as ProviderModel;

class Provider extends Controller
{
    public function paginateProviders(Request $request)
    {
        $searchQuery = $request->input('q');
        $city = $request->input('city');
        
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

        if (! empty($city)) {
            $providers->where('city', $city);      
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
