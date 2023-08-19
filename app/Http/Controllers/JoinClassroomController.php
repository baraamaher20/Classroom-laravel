<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Scopes\UserClassroomScope;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JoinClassroomController extends Controller
{
    public function create($id)
    {
        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)->active()->findOrFail($id);

        try {
            $this->exists($classroom, Auth::id());
        } catch (Exception $e) {
            return redirect()->route('classrooms.show', $id)->with('Info', 'You already joined in this classroom!');
        }

        return view('classrooms.join', compact('classroom'));
    }



    public function store(Request $request, $id)
    {
        $request->validate([
            'role' => 'in:student|teacher',
        ]);
        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)->active()->findOrFail($id);

        try {
            $this->exists($classroom, Auth::id());
        } catch (Exception $e) {
            return redirect()->route('classrooms.show', $id)->with('Info', 'You already joined in this classroom!');
        }

        $classroom->join(Auth::id(), $request->input('role', 'student'));
        return redirect()->route('classrooms.show', $id)->with('Info', 'You joined in this classroom successfully');
    }

    public function exists(Classroom $classroom, $user_id)
    {
        $exists = $classroom->users()->wherePivot('user_id', $user_id)->exists();
        if ($exists) {
            throw new Exception('User already joined the classroom!');
        }
    }
}
