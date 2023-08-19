<x-app-layout>

    <x-slot:title>Join To Classroom</x-slot:title>
    <div class="container">
        <div class="d-flex justify-content-center p-3 my-4 border shadow-sm rounded-1">
            <div class="card m-4 text-center" style="width: 30rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $classroom->name }}</h5>
                    <p class="card-text">Click on the Join icon to enter the Classroom</p>
                    <form action="{{ route('classrooms.join', $classroom->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Join</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
