<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->query('search');

        $countries = Country::orderBy('name', 'asc')
            ->when($search, function ($query) use($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->simplePaginate(15);

        return CountryResource::collection($countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCountryRequest $request)
    {
        [ 'name' => $name] = $request->validated();

        $country = Country::create([
            'country_uid' => Str::uuid(),
            'name' => $name,
            'slug' => Str::slug($name),
        ]);

        return response()->json([
            'data' => new CountryResource($country),
            'message' => 'Country details persisted successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        return response()->json([
            'data' => new CountryResource($country),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country->update($request->validated());

        return response()->json([
            'data' => new CountryResource($country),
            'message' => 'Country details persisted successfully',
        ]);
    }
}
