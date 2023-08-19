<x-app-layout>

    <x-slot:title>Edit Classroom</x-slot:title>
    <div class="container p-3 my-4 border shadow-sm rounded-1">

        <h2 class="mb-4">Edit Classroom </h2>
        <form action="{{ route('classrooms.update', $classroom->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            @include('classrooms._form', [
                'button_lable' => 'Update Classroom',
            ])
        </form>
    </div>
</x-app-layout>
