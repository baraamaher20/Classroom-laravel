<x-app-layout>

    <x-slot:title>Edit Classwork</x-slot:title>
    <div class="container p-3 my-4 border shadow-sm rounded-1">

        <x-messages />
        <h2 class="mb-4">Edit Classwork</h2>
        <form action="{{ route('classrooms.classworks.update', [$classroom->id, $classwork->id, 'type' => $type]) }}"
            method="post">
            @csrf
            @method('put')
            @include('classworks._form')
            <div class="d-flex col-3">
                <button type="submit" class="mx-1 btn btn-outline-primary">Update</button>
            </div>
        </form>





    </div>

</x-app-layout>
