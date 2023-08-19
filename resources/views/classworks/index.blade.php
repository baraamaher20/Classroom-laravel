<x-app-layout>

    <x-slot:title>Classworks</x-slot:title>
    <div class="container p-3 my-4 border shadow-sm rounded-1">
        <x-messages />
        <div class="d-flex justify-content-between mb-2">
            <div class="h2">Classworks</div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    + Create
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item"
                            href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'assignment']) }}">Assignment</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'material']) }}">Material</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'question']) }}">Question</a>
                    </li>
                </ul>
            </div>
        </div>
        <form class="d-flex align-items-center col-3" action="{{ URL::current() }}" method="get">
            <input class="form-control me-1" type="text" name="search" placeholder="Search...">
            <button type="submit" class="btn btn-sm btn-primary">search</button>
        </form>
    </div>
    @forelse ($classworks as $group)
        <div class="container p-3 my-4 border shadow-sm rounded-1">
            <h4>{{ $group->first()->topic->name ?? 'Deleted Topic' }}</h4>
            <hr>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($group as $classwork)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading{{ $classwork->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse{{ $classwork->id }}" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                {{ $classwork->title }} / {{ $classwork->topic->name }}
                            </button>
                        </h2>
                        <div id="flush-collapse{{ $classwork->id }}" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                {{ $classwork->description }}
                                <a type="button" class="btn btn-sm btn-outline-primary"
                                    href="{{ route('classrooms.classworks.show', [$classroom->id, $classwork->id]) }}">see
                                    more</a>
                                <a type="button" class="btn btn-sm btn-outline-dark"
                                    href="{{ route('classrooms.classworks.edit', [$classroom->id, $classwork->id]) }}">Edit</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="container p-3 border shadow-sm rounded-1">
            <p class="text-center fs-6 mb-0">No Classworks Yet. Create one to get started!</p>
        </div>
    @endforelse

</x-app-layout>
