<x-app-layout>

    <x-slot:title>add post</x-slot:title>
    <div class="container p-3 my-4 border shadow-sm rounded-1">

        <h2 class="mb-4">Add New Post</h2>

        <form action="{{ route('classrooms.posts.store', $classroom->id) }}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" @class(['form-control', 'is-invalid' => $errors->has('title')]) id="title" name="title" placeholder="Title"
                    value="{{ old('title') }}">
                <label for="title">Title</label>
                <x-error field-name="title" />
            </div>
            <div class="form-floating mb-3">
                <textarea @class(['form-control', 'is-invalid' => $errors->has('content')]) id="content" name="content" value="{{ old('content') }}" placeholder="Content"></textarea>
                <label for="content">Content</label>
                <x-error field-name="content" />
            </div>

            <div class="d-flex col-3">
                <button type="submit" class="mx-1 btn btn-outline-primary">Add Post</button>
                <a href="{{ route('classrooms.posts.index', $classroom->id) }}" class="btn btn-outline-primary">Home</a>
            </div>
        </form>

    </div>

</x-app-layout>
