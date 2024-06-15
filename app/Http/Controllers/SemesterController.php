<?php

namespace App\Http\Controllers;

use App\Http\Filters\GlobalFilter;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Models\Semester;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = new GlobalFilter([
            'id', 'name'
        ]);
        $models = QueryBuilder::for(Semester::class)
            ->allowedFilters($filters->fields())
            ->allowedSorts(['id', 'name'])
            ->paginate()
            ->withQueryString();
        return Inertia::render('Semesters/Index',[
            'models' => JsonResource::collection($models)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Semesters/Fields');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSemesterRequest $request)
    {
        Semester::create($request->validated());
        return to_route('semesters.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Semester $semester)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semester $semester)
    {
        return Inertia::render('Semesters/Fields', [
            'model' => $semester
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSemesterRequest $request, Semester $semester)
    {
        $semester->fill($request->validated());
        $semester->save();
        return to_route('semesters.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester)
    {
        $semester->delete();
        return to_route('semesters.index');
    }
}
