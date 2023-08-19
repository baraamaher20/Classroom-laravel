<x-app-layout>

    <x-slot:title>Posts</x-slot:title>
    <div class="container p-3 my-4 border shadow-sm rounded-1">
        <x-messages />
        <div class="d-flex justify-content-start row">
            @forelse ($classroom->posts as $post)
                <div class="col-md-6">
                    <div class="d-flex flex-column comment-section">
                        <div class="bg-white p-2">
                            <div class="d-flex flex-row user-info">
                                <img class="rounded-circle me-1"
                                    src="{{ url('https://ui-avatars.com/api/?rounded=true&size=16&name=' . $post->user->name) }}"
                                    width="32">
                                <div class="d-flex flex-column justify-content-start ml-2"><span
                                        class="d-block font-weight-bold name">{{ $post->user->name }}</span><span
                                        class="date text-black-50">{{ $post->created_at->diffForHumans() }}</span></div>
                            </div>
                            <div class="mt-2">
                                <p class="comment-text">{{ $post->content }}</p>
                            </div>
                        </div>

                        <div class="bg-light p-2">
                            <div class="">
                                @foreach ($post->comments as $comment)
                                    <div class="d-flex justify-content-start border rounded p-2 mb-2">
                                        <div class="me-1">
                                            <img src="{{ url('https://ui-avatars.com/api/?rounded=true&size=32&name=' . $comment->user->name) }}"
                                                alt="">
                                        </div>
                                        <div>
                                            <div class="d-flex">
                                                <h5 class="me-3">{{ $comment->user->name }}</h5>
                                                <p class="text-muted fs-6">{{ $comment->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                            <p>{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle me-2"
                                    src="{{ url('https://ui-avatars.com/api/?rounded=true&size=32&name=' . Auth::user()->name) }}"
                                    width="32">
                                <form action="{{ route('comments.store') }}" method="post">
                                    <div class="d-flex align-items-end">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $post->id }}">
                                        <input type="hidden" name="type" value="post">
                                        <div class="form-floating me-2">
                                            <textarea @class(['form-control', 'is-invalid' => $errors->has('content')]) id="content" name="content" value="{{ old('content') }}"></textarea>
                                            <label for="content">Comment</label>
                                            <x-error field-name="content" />
                                        </div>
                                        <div class="">
                                            <button class="btn btn-primary btn-sm shadow-none" type="submit">Post
                                                comment</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse

        </div>

        <a href="{{ route('classrooms.posts.create', $classroom->id) }}" class="col-1 mx-1 mt-3 btn btn-success">Add
            Post</a>
    </div>



</x-app-layout>
