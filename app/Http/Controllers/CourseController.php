<?php

namespace App\Http\Controllers;

use App\Http\Filters\GlobalFilter;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\SelectResource;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = new GlobalFilter([
            'id', 'name'
        ]);
        $models = QueryBuilder::for(Course::class)
            ->allowedFilters($filters->fields())
            ->allowedSorts(['id', 'name', 'semester_id'])
            ->with('semester')
            ->paginate()
            ->withQueryString();
        return Inertia::render('Courses/Index', [
            'models' => JsonResource::collection($models)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        Course::create($request->validated());
        return to_route('courses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Courses/Fields', [
            'semesters' => SelectResource::collection(Semester::all())
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return Inertia::render('Courses/Fields', [
            'model' => $course,
            'semesters' => SelectResource::collection(Semester::all())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        $course->fill($request->validated());
        $course->save();
        return to_route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return to_route('courses.index');
    }
}
