<x-app-layout>

    <x-slot:title>Classrooms</x-slot:title>
    <div class="container p-3 my-4 border shadow-sm rounded-1">
        <x-messages />
        <h1 class="mb-4">Classrooms</h1>
        <div class="row">
            @foreach ($classrooms as $classroom)
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="{{ asset($classroom->cover_image_url) }}" class="card-img-top img-fluid img-thumbnail"
                            alt="">

                        <div class="card-body">
                            <h5 class="card-title">{{ $classroom->name }}</h5>
                            <p class="card-text mb-2">{{ $classroom->section }} - {{ $classroom->room }}</p>
                            <div class="d-flex">
                                <a href="{{ route('classrooms.show', $classroom->id) }}"
                                    class="btn btn-outline-primary">View</a>
                                <a href="{{ route('classrooms.edit', $classroom->id) }}"
                                    class="btn btn-outline-dark mx-1">Edit</a>
                                <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-outline-danger">delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="{{ route('classrooms.create') }}" class="col-1 mx-1 mt-3 btn btn-success">Add</a>
        <a href="{{ route('classroom.trashed') }}" class="col-1 mx-1 mt-3 btn btn-danger">Trash</a>

    </div>

</x-app-layout>
