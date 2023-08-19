<x-app-layout>

    <x-slot:title>Topics</x-slot:title>
    <div class="container p-3 my-4 border shadow-sm rounded-1">
        <x-messages />
        <h1 class="mb-4">Topics</h1>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; ?>
                    @foreach ($classroom->topics as $topic)
                        <tr>
                            <th>{{ $index++ }}</th>
                            <td>{{ $topic->name }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('classrooms.topics.edit', [$classroom, $topic->id]) }}"
                                        class="btn btn-outline-dark mx-1">Edit</a>
                                    <form action="{{ route('classrooms.topics.destroy', [$classroom, $topic->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-outline-danger">delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('classrooms.topics.create', $classroom) }}" class="col-1 mx-1 mt-3 btn btn-success">Add</a>

    </div>

</x-app-layout>
