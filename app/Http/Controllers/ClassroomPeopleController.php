<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomPeopleController extends Controller
{
    public function index(Classroom $classroom)
    {
        $auth_id = Auth::id();
        return view('classrooms.people', compact('classroom', 'auth_id'));
    }

    public function destroy(Request $request, Classroom $classroom)
    {
        $request->validate([
            'user_id' => ['required'],
        ]);
        $user_id = $request->input('user_id');
        if ($user_id != $classroom->user_id) {
            $classroom->users()->detach($user_id);
            return redirect()->route('classroom.people', $classroom->id)->with('Delete', 'User Removed successfully');
        }
        return redirect()->route('classroom.people', $classroom->id)->with('Erorr', 'Cannot Remove This User!');
    }
}
