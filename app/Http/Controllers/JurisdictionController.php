<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJurisdictionRequest;
use App\Http\Resources\JurisdictionResource;
use App\Models\Jurisdiction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JurisdictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countryUid = request()->query('country_uid');

        $jurisdictions = Jurisdiction::orderBy('name')
            ->with(['parent', 'boundary'])
            ->when($countryUid, function ($query) use($countryUid) {
                $query->whereHas('boundary.country', function ($query) use($countryUid) {
                    $query->where('countries.country_uid', $countryUid);
                });
            })
            ->simplePaginate(15);

        return JurisdictionResource::collection($jurisdictions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateJurisdictionRequest $request)
    {
        $jurisdiction = Jurisdiction::create(array_merge([
            'jurisdiction_uid' => Str::uuid(),
        ], $request->validated()));

        $jurisdiction->load('parent');

        return response()->json([
            'data' => new JurisdictionResource($jurisdiction),
            'message' => 'Jurisdiction details persisted successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jurisdiction  $jurisdiction
     * @return \Illuminate\Http\Response
     */
    public function show(Jurisdiction $jurisdiction)
    {
        $jurisdiction->load(['parent', 'boundary']);

        return response()->json([
            'data' => new JurisdictionResource($jurisdiction),
        ]);
    }
}
