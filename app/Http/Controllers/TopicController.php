<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Http\Resources\SelectResource;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Inertia;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Topics/Index', [
            'models' => JsonResource::collection(Topic::with('semester', 'course', 'chapter')->paginate())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TopicRequest $request)
    {
        Topic::create($request->validated());
        return to_route('topics.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Topics/Fields', [
            'semesters' => SelectResource::collection(Semester::all()),
            'courses' => SelectResource::collection(Course::all()),
            'chapters' => SelectResource::collection(Chapter::all()),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        return Inertia::render('Topics/Fields', [
            'model' => $topic,
            'semesters' => SelectResource::collection(Semester::all()),
            'courses' => SelectResource::collection(Course::all()),
            'chapters' => SelectResource::collection(Chapter::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->validated());
        $topic->save();
        return to_route('topics.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();
        return to_route('topics.index');
    }
}
