<?php

namespace App\Http\Controllers;

use App\Http\Filters\GlobalFilter;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\SelectResource;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Question;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
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
                AllowedFilter::exact('chapter_id'),
                AllowedFilter::callback('has_answer', function ($query, $value) {
                    if ($value) {
                        $query->whereNotNull('answer');
                    } else {
                        $query->whereNull('answer');
                    }
                }),
                AllowedFilter::callback('q', function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->whereAny(['title', 'description'], 'like', "%$value%")
                            ->orWhereHas('tags', function ($query) use ($value) {
                                $query->where('name', 'like', "%$value%");
                            });
                    });
                })
            ])
            ->allowedSorts(['id', 'semester_id', 'course_id', 'chapter_id', 'topic_id'])
            ->when(session('semester_id'), fn(Builder $query, $value) => $query->where('semester_id', $value))
            ->when(session('course_id'), fn(Builder $query, $value) => $query->where('course_id', $value))
            ->when(session('chapter_id'), fn(Builder $query, $value) => $query->where('course_id', $value))
            ->with('semester', 'course', 'chapter', 'topic', 'tags:id,name')
            ->defaultSort('-id')
            ->paginate()
            ->withQueryString();

        return Inertia::render('Questions/Index', [
            'models' => JsonResource::collection($models),
            'chapters' => SelectResource::collection(Chapter::query()
                ->when(session('semester_id'), fn(Builder $query, $value) => $query->where('semester_id', $value))
                ->when(session('course_id'), fn(Builder $query, $value) => $query->where('course_id', $value))->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request)
    {
        if ($request->boolean('create_multiple')) {
            $questions = explode('---', $request->questions);
            $questions = Arr::map($questions, function ($question) {
                return trim($question);
            });
            $questionsModels = collect();
            foreach ($questions as $questionTitle) {
                $questionsModels->push(Question::make($request->only([
                        'semester_id',
                        'course_id',
                        'chapter_id',
                        'topic_id',
                    ]) + ['title' => $questionTitle]));
            }
            Question::insert($questionsModels->toArray());
        } else {
            $question = Question::create($request->validated());

            if ($request->filled('tags')) {
                $question->syncTags($request->input('tags'));
            }
        }

        return back()->with('chapter_id', $request->input('chapter_id'));
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
            'semester_id' => session('semester_id'),
            'course_id' => session('course_id'),
            'chapter_id' => session('chapter_id'),
        ]);
    }

    public function createMultiple()
    {
        return Inertia::render('Questions/Fields', [
            'semesters' => SelectResource::collection(Semester::all()),
            'courses' => SelectResource::collection(Course::all()),
            'chapters' => SelectResource::collection(Chapter::all()),
            'semester_id' => session('semester_id'),
            'course_id' => session('course_id'),
            'chapter_id' => session('chapter_id'),
            'createMultiple' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        $next = Question::where('id', '>', $question->id)
            ->where('chapter_id', $question->chapter_id)
            ->value('id');
        if (empty($next)) {
            $next = Question::where('id', '>', $question->id)
                ->where('chapter_id', $question->chapter_id + 1)
                ->value('id');
        }

        $prev = Question::where('id', '<', $question->id)->latest('id')
            ->where('chapter_id', $question->chapter_id)
            ->value('id');

        if (empty($prev)) {
            $prev = Question::where('id', '<', $question->id)->latest('id')
                ->where('chapter_id', $question->chapter_id - 1)
                ->value('id');
        }
        return Inertia::render('Questions/Show', [
            'model' => QuestionResource::make($question->load(['semester', 'course', 'chapter', 'topic', 'tags'])),
            'next' => $next,
            'prev' => $prev,
        ]);
    }

    public function random()
    {
        if (session()->has('random')) {
            $question = Question::find(session('random'));
        } else {
            $question = Question::query()
                ->when(session('semester_id'), fn(Builder $query, $value) => $query->where('semester_id', $value))
                ->when(session('course_id'), fn(Builder $query, $value) => $query->where('course_id', $value))
                ->when(session('chapter_id'), fn(Builder $query, $value) => $query->where('chapter_id', $value))
                ->inRandomOrder()
                ->first();
        }


        if (empty($question)) {
            return back()->with('status', 'Question not found!');
        }

        return Inertia::render('Questions/Show', [
            'model' => QuestionResource::make($question?->load(['semester', 'course', 'chapter', 'topic', 'tags']))
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
            'tags' => $question->tags->pluck('name'),
            // 'allTags' => Tag::pluck('name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, Question $question)
    {
        //get fields that are not null

        $values = array_filter($request->validated(), fn($value) => $value !== null);

        $question->fill($values);
        $question->save();

        if ($request->filled('tags')) {
            $question->syncTags($request->input('tags'));
        }

        // if the request was send from the show page redirect back to the show page

        if ($request->has('random')) {
            return back()->with('random', $question->id);
        }

        return to_route('questions.show', $question);
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
