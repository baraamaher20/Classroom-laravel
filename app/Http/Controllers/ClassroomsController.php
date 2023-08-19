<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomRequest;
use App\Models\Classroom;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ClassroomsController extends Controller
{

    public function index()
    {
        $classrooms = Classroom::active()->get();
        return view('classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('classrooms.create', [
            'classroom' => new Classroom(),
        ]);
    }

    public function store(ClassroomRequest $request)
    {
        $validate = $request->validated();
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $path = $file->store('/covers', [
                'disk' => Classroom::$disk,
            ]);
            $validate['cover_image_path'] = $path;
        }
        // $validate['code'] = Str::random(8); in the Observer Class
        // $validate['user_id'] = Auth::id(); in the Observer Class

        DB::beginTransaction();
        try {
            $classroom = Classroom::create($validate);
            $classroom->join(Auth::id(), 'teacher');
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }

        session()->flash('Add', 'Added successfully');
        return redirect()->route('classrooms.index');
    }

    public function show(Classroom $classroom) //Model Binding
    {
        $invitation_link = URL::signedRoute('classrooms.join', [
            'classroom' => $classroom->id,
            'code' => $classroom->code,
        ]);

        // $students = $classroom->get_students();
        // $teachers = $classroom->get_teachers();

        session()->put('classroom_id', $classroom->id);
        return view('classrooms.show', compact('classroom', 'invitation_link'));
    }

    public function edit(Classroom $classroom) //Model Binding
    {
        return view('classrooms.edit', compact('classroom'));
    }

    public function update(ClassroomRequest $request, Classroom $classroom) //Model Binding
    {
        $validate = $request->validated();
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $path = $file->store('/covers', [
                'disk' =>  Classroom::$disk,
            ]);
            $validate['cover_image_path'] = $path;
        }

        $old = $classroom->cover_image_path;
        $classroom->update($validate);

        if ($old && $old != $classroom->cover_image_path) {
            Storage::disk(Classroom::$disk)->delete($old);
        }
        session()->flash('Edit', 'Modified successfully');
        return redirect()->route('classrooms.index');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete(); //delete from db
        session()->flash('Delete', 'Deleted successfully');
        return redirect()->route('classrooms.index');
    }

    public function trashed()
    {
        $classrooms = Classroom::onlyTrashed()->latest('deleted_at')->get();
        return view('classrooms.trashed', compact('classrooms'));
    }

    public function restore($id)
    {
        $classroom = Classroom::onlyTrashed()->findOrFail($id);
        $classroom->restore();
        return redirect()
            ->route('classrooms.index')
            ->with('Restore', "Classroom ({$classroom->name}) restored");
    }

    public function forceDelete($id)
    {
        $classroom = Classroom::onlyTrashed()->findOrFail($id);
        $classroom->forceDelete();
        //delete from disk in the Observer Class
        return redirect()
            ->route('classrooms.index')
            ->with('Delete', "Classroom ({$classroom->name}) deleted forever!");
    }
}
