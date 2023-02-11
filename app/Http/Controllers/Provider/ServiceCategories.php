<?php

namespace App\Http\Controllers\Provider;

use App\Http\Requests\Provider\IndexRequest as ProviderIndexRequest;
use App\Http\Requests\Provider\Category\CreateRequest as CreateCategoryRequest;
use App\Http\Requests\Provider\Category\UpdatedRequest as UpdateCategoryRequest;
use App\Models\{ ServiceCategory };
use App\Http\Controllers\Controller;
use App\Http\Resources\{ServiceTypeResource, ServiceCategoryResource};
use Illuminate\Http\Request;

class ServiceCategories extends Controller
{
    public function paginate(Request $request) {

        $categories = ServiceCategory::paginate(30);

        return response()->json([
            'success' => true,
            'resource' => $categories
        ]);
    }

    public function groupByCategory(Request $request) {
        $categories = ServiceCategory::with([
            'services' => function ($query) {
                $query->where('approved', 1); 
        }])->get();

        return response()->json([
            'success' => true,
            'resource' => ServiceCategoryResource::collection($categories)
        ]);
    }

    public function getByCategory(Request $request, ServiceCategory $category) {
        return response()->json([
            'success' => true,
            'resource' => ServiceTypeResource::collection($category->services)
        ]);
    }
    
    public function delete(ProviderIndexRequest $request, ServiceCategory $category) {

        $category->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function update(UpdateCategoryRequest $request, ServiceCategory $category) {
        
        $input = $request->validated();

        $category->fill($input);
        $category->save();

        return response()->json([
            'success' => true
        ]);
    }


    public function create(CreateCategoryRequest $request) {
         
        ServiceCategory::create(array_merge($request->validated()));

        return response()->json([
            'success' => true
        ]);
    }
}
