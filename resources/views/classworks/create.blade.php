<x-app-layout>

    <x-slot:title>Create Classwork</x-slot:title>
    <div class="container p-3 my-4 border shadow-sm rounded-1">

        <h2 class="mb-4">Create Classwork</h2>

        <form action="{{ route('classrooms.classworks.store', [$classroom->id, 'type' => $type]) }}" method="post">
            @csrf
            @include('classworks._form')
            <div class="d-flex col-3">
                <button type="submit" class="mx-1 btn btn-outline-primary">Create</button>
            </div>
        </form>
    </div>
</x-app-layout>
