<x-app-layout>

    <x-slot:title>People</x-slot:title>
    <div class="container p-3 my-4 border shadow-sm rounded-1">
        <x-messages />
        <div class="row">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                            Teachers
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse show"
                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul>
                                @forelse ($classroom->teachers as $teacher)
                                    <li class="d-flex justify-content-between mb-1">
                                        <p class="mb-0">{{ $teacher->name }}</p>
                                        <form action="{{ route('classroom.people.destroy', $classroom->id) }}"
                                            method="post" class="mb-0">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="user_id" value="{{ $teacher->id }}">

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                @if ($teacher->id == $auth_id)
                                                    leave
                                                @else
                                                    Remove
                                                @endif
                                            </button>
                                        </form>
                                    </li>
                                @empty
                                    <div class="container p-3 border shadow-sm rounded-1">
                                        <p class="text-center fs-6 mb-0">No Teachers Yet.
                                        </p>
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="true" aria-controls="flush-collapseTwo">
                            Students
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul>
                                @forelse ($classroom->students as $student)
                                    <li class="d-flex justify-content-between mb-1">
                                        <p class="mb-0">{{ $student->name }}</p>
                                        <form action="{{ route('classroom.people.destroy', $classroom->id) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="user_id" value="{{ $student->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                @if ($student->id == $auth_id)
                                                    leave
                                                @else
                                                    Remove
                                                @endif
                                            </button>
                                        </form>
                                    </li>
                                @empty
                                    <div class="container p-3 border shadow-sm rounded-1">
                                        <p class="text-center fs-6 mb-0">No Students Yet.
                                        </p>
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:js>
        <script>
            function myFunction() {
                var copyText = document.getElementById("copy");
                navigator.clipboard.writeText(copyText.value);
                alert("Copied successfully");
            }
        </script>
    </x-slot:js>
</x-app-layout>
