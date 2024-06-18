<?php

namespace App\Http\Controllers;

use App\Http\Filters\GlobalFilter;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\SelectResource;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Question;
use App\Models\Semester;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = new GlobalFilter(['title', 'description']);
        $models = QueryBuilder::for(Question::class)
            ->allowedFilters([...$filters->fields(),
                'chapter_id',
                'topic_id',
                AllowedFilter::callback('has_answer', function ($query, $value){
                    if ($value){
                        $query->whereNotNull('answer');
                    }else{
                        $query->whereNull('answer');
                    }
                })
            ])
            ->allowedSorts(['id', 'semester_id', 'course_id', 'chapter_id', 'topic_id'])
            ->when(session('semester_id'), fn(Builder $query, $value) => $query->where('semester_id', $value))
            ->when(session('course_id'), fn(Builder $query, $value) => $query->where('course_id', $value))
            ->with('semester', 'course', 'chapter', 'topic')
            ->paginate()
            ->withQueryString();
        return Inertia::render('Questions/Index', [
            'models' => JsonResource::collection($models),
            'chapters' => SelectResource::collection(Chapter::query()
                ->when(session('semester_id'), fn(Builder $query, $value) => $query->where('semester_id', $value))
                ->when(session('course_id'), fn(Builder $query, $value) => $query->where('course_id', $value))->get()),
            'topics' => SelectResource::collection(Topic::query()
                ->when(session('semester_id'), fn(Builder $query, $value) => $query->where('semester_id', $value))
                ->when(session('course_id'), fn(Builder $query, $value) => $query->where('course_id', $value))
                ->when(request('filter.chapter_id'), fn(Builder $query, $value) => $query->where('chapter_id', $value))
                ->get()),
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

    public function random()
    {
        $question = Question::query()
            ->when(session('semester_id'), fn(Builder $query, $value) => $query->where('semester_id', $value))
            ->when(session('course_id'), fn(Builder $query, $value) => $query->where('course_id', $value))
            ->inRandomOrder()
            ->first();
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
