<?php

namespace App\Http\Controllers;

use App\Http\Filters\GlobalFilter;
use App\Http\Requests\ChapterRequest;
use App\Http\Resources\SelectResource;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = new GlobalFilter([
            'id', 'name', 'semester.name', 'course.name'
        ]);
        $models = QueryBuilder::for(Chapter::class)
            ->allowedFilters($filters->fields())
            ->allowedSorts(['id', 'name', 'semester_id', 'course_id'])
            ->with('semester', 'course')
            ->paginate()
            ->withQueryString();
        return Inertia::render('Chapters/Index', [
            'models' => JsonResource::collection($models)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChapterRequest $request)
    {
        Chapter::create($request->validated());
        return to_route('chapters.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Chapters/Fields', [
            'semesters' => SelectResource::collection(Semester::all()),
            'courses' => SelectResource::collection(Course::all()),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chapter $chapter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chapter $chapter)
    {
        return Inertia::render('Chapters/Fields', [
            'model' => $chapter,
            'semesters' => SelectResource::collection(Semester::all()),
            'courses' => SelectResource::collection(Course::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChapterRequest $request, Chapter $chapter)
    {
        $chapter->fill($request->validated());
        $chapter->save();
        return to_route('chapters.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter)
    {
        $chapter->delete();
        return to_route('chapters.index');
    }
}
