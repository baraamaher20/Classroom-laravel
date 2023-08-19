<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index(Classroom $classroom)
    {
        $posts = $classroom->posts()->with('comments')->latest()->get();
        return view('posts.index', compact('classroom', 'posts'));
    }

    public function create(Classroom $classroom)
    {
        return view('posts.create', compact('classroom'));
    }


    public function store(Request $request, Classroom $classroom)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:64'],
            'content' => ['required', 'string'],
        ]);

        $request->merge([
            'user_id' => Auth::id(),
        ]);

        $classroom->posts()->create($request->all());

        return redirect()->route('classrooms.posts.index', $classroom->id)
            ->with('Add', 'Added Post Successfuly');
    }
}
