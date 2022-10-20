<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBoundaryRequest;
use App\Http\Resources\BoundaryResource;
use App\Models\Boundary;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BoundaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $level = request()->query('level');
        $countryUid = request()->query('country_uid');

        $boundaries = Boundary::orderBy('level')
            ->when($level, function ($query) use($level) {
                $query->where('level', (int) $level);
            })
            ->when($countryUid, function ($query) use($countryUid) {
                $query->whereHas('country', function ($query) use($countryUid) {
                    $query->where('country_uid', $countryUid);
                });
            })
            ->simplePaginate(15);

        return BoundaryResource::collection($boundaries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBoundaryRequest $request)
    {
        $boundary = Boundary::create(array_merge([
            'boundary_uid' => Str::uuid(),
        ], $request->validated()));

        return response()->json([
            'data' => new BoundaryResource($boundary),
            'message' => 'Boundary details persisted successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Boundary  $boundary
     * @return \Illuminate\Http\Response
     */
    public function show(Boundary $boundary)
    {
        return response()->json([
            'data' => new BoundaryResource($boundary),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Boundary  $boundary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Boundary $boundary)
    {
        //
    }
}
