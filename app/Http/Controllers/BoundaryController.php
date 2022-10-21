<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBoundaryRequest;
use App\Http\Requests\ListBoundariesRequest;
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
    public function index(ListBoundariesRequest $request)
    {   
        $queries = $request->validated();

        $boundaries = Boundary::orderBy('level')
            ->with(['country'])
            ->when(
                isset($queries['levels']), 
                function ($query) use($queries) {
                    $query->whereIn('level', $queries['levels']);
                }
            )
            ->when(
                isset($queries['country_uid']), 
                function ($query) use($queries) {
                    $query->whereHas('country', function ($query) use($queries) {
                        $query->where('country_uid', $queries['country_uid']);
                    });
                }
            )
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

        $boundary->load('country');

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
}
