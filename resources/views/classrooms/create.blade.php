<x-app-layout>
    <x-slot:title>Create Classroom</x-slot:title>
    <div class="container p-3 my-4 border shadow-sm rounded-1">
        <h1 class="mb-4">Create New Classroom</h1>


        <form action="{{ route('classrooms.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('classrooms._form', [
                'button_lable' => 'Create Classroom',
            ])
        </form>
    </div>
</x-app-layout>
