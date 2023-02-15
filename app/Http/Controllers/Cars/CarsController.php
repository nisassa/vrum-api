<?php

namespace App\Http\Controllers\Cars;

use App\Http\Requests\Cars\{CreateCarRequest, EditCarRequest};
use App\Http\Requests\Client\IndexRequest;
use App\Models\Car;
use App\Http\Resources\CarResource;
use App\Http\Resources\AdjustableDetailLevelResource;
use App\Http\Controllers\Controller;

class CarsController extends Controller
{
    public function create(CreateCarRequest $request) {
        $car = Car::create($request->validated());
        return response()->json([
            'success' => true,
            'resource' => new CarResource($car, AdjustableDetailLevelResource::DETAIL_ALL)
        ]);
    }

    public function edit(EditCarRequest $request, Car $car) {

        $car->fill($request->validated())->save();

        return response()->json([
            'success' => true,
            'resource' => new CarResource($car, AdjustableDetailLevelResource::DETAIL_ALL)
        ]);
    }

    public function myCars(IndexRequest $request) {

        $cars = Car::where('client_id', $request->user()->id)->get();
        
        return response()->json([
            'success' => true,
            'resource' => CarResource::collection($cars)
        ]);
    }

    public function destroy(IndexRequest $request, Car $car) {

        $car->delete();
    
        return response()->json([
            'success' => true,
        ]);
    }
}
