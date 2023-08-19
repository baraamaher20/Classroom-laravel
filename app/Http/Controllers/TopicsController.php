<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Models\Classroom;
use App\Models\Topic;

class TopicsController extends Controller
{
    public function index(Classroom $classroom)
    {
        return view('topics.index', compact('classroom'));
    }

    public function create(Classroom $classroom)
    {
        return view('topics.create', compact('classroom'));
    }

    public function store(TopicRequest $request, $classroom)
    {
        $validated = $request->validated();
        $validated['classroom_id'] = $classroom;
        Topic::create($validated);
        session()->flash('Add', 'Added successfully');
        return redirect()->route('classrooms.topics.index', $classroom);
    }

    public function edit(Classroom $classroom, Topic $topic) //Model Binding
    {
        // $topic = Topic::findOrFail($topic);
        return view('topics.edit', compact('classroom', 'topic'));
    }

    public function update(TopicRequest $request, $classroom, $topic) //Model Binding
    {
        $topic = Topic::findOrFail($topic);
        $validate = $request->validated();
        $topic->update($validate);
        session()->flash('Edit', 'Modified successfully');
        return redirect()->route('classrooms.topics.index', compact('classroom'));
    }

    public function destroy($classroom, $topic)
    {
        $topic = Topic::findOrFail($topic);
        $topic->delete();
        session()->flash('Delete', 'Deleted successfully');
        return redirect()->route('classrooms.topics.index', $classroom);
    }
}
