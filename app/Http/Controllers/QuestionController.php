<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Http\Resources\SelectResource;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Inertia;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Questions/Index', [
            'models' => JsonResource::collection(Question::with('semester', 'course', 'chapter', 'topic')->paginate())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request)
    {
        Question::create($request->validated());
        return to_route('questions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Questions/Fields', [
            'semesters' => SelectResource::collection(Semester::all()),
            'courses' => SelectResource::collection(Course::all()),
            'chapters' => SelectResource::collection(Chapter::all()),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return Inertia::render('Questions/Show', [
            'model' => $question->load(['semester', 'course', 'chapter', 'topic'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        return Inertia::render('Questions/Fields', [
            'model' => $question,
            'semesters' => SelectResource::collection(Semester::all()),
            'courses' => SelectResource::collection(Course::all()),
            'chapters' => SelectResource::collection(Chapter::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $question->fill($request->validated());
        $question->save();
        return to_route('questions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return to_route('questions.index');
    }
}
