<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Classwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassworkController extends Controller
{

    public function getType(Request $request)
    {
        $type =  $request->query('type');
        $allowed_type = [Classwork::TYPE_ASSIGNMENT, Classwork::TYPE_MATERIAL, Classwork::TYPE_QUESTION];
        if (!in_array($type, $allowed_type)) {
            $type = Classwork::TYPE_ASSIGNMENT;
        }
        return $type;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Classroom $classroom)
    {
        $classworks = $classroom->classworks()->with('topic')
            ->when($request->search, function ($builder, $value) {
                $builder->where('title', 'LIKE', "%{$value}%")
                    ->orWhere('description', 'LIKE', "%{$value}%");
            })
            ->latest('published_at')->lazy();
        $classworks = $classworks->groupBy('topic_id');
        // dd($classworks);
        return view('classworks.index', compact('classroom', 'classworks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Classroom $classroom)
    {
        $type = $this->gettype($request);
        $classwork = new Classwork();
        return view('classworks.create', compact('classroom', 'type', 'classwork'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {
        $type = $this->gettype($request);
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'grade' => ['required_if:type,assignment', 'numeric', 'min:0'],
            'due' => ['required_if:type,assignment', 'date', 'after:published_at'],
        ]);

        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type,
            'options' => [
                'grade' => $request->input('grade'),
                'due' => $request->input('due'),
            ],
        ]);
        // dd($request);
        $classwork = $classroom->classworks()->create($request->all());
        $classwork->users()->attach($request->input('students'));

        return redirect()->route('classrooms.classworks.index', $classroom->id)
            ->with('Add', 'Added Classwork Successfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom, Classwork $classwork)
    {
        $submissions = Auth::user()->submissions()->where('classwork_id', $classwork->id)->get();
        return view('classworks.show', compact('classroom', 'classwork', 'submissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Classroom $classroom, Classwork $classwork)
    {
        $type = $classwork->type;
        $assigned = $classwork->users()->pluck('id')->toArray();
        return view('classworks.edit', compact('classroom', 'classwork', 'type', 'assigned'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, Classwork $classwork)
    {
        $type = $classwork->type;
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'grade' => ['required_if:type,assignment', 'numeric', 'min:0'],
            'due' => ['required_if:type,assignment', 'date', 'after:published_at'],
        ]);

        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type,
            'options' => [
                'grade' => $request->input('grade'),
                'due' => $request->input('due'),
            ],
        ]);
        $classwork->update($request->all());
        $classwork->users()->sync($request->input('students'));
        return back()->with('Edit', 'Classwork Updated Successfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom, Classwork $classwork)
    {
        //
    }
}
