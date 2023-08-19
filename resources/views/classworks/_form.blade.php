<div class="row">
    <div class="col-md-8">
        <div class="form-floating mb-3">
            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('title')]) id="title" name="title" placeholder="title"
                value="{{ old('title', $classwork->title) }}">
            <label for="title">Classwork title</label>
            <x-error field-name="title" />
        </div>
        <div class="form-floating mb-3">
            <textarea @class(['form-control', 'is-invalid' => $errors->has('description')]) id="description" name="description" placeholder="Description (Optional)">{{ old('description', $classwork->description) }}</textarea>
            <label for="description">Description (Optional)</label>
            <x-error field-name="description" />
        </div>

        <div class="form-floating mb-3">
            <select class="form-select" name="topic_id" id="topic_id">
                <option value="">Select One</option>
                @foreach ($classroom->topics as $topic)
                    <option @selected($topic->id == $classwork->topic_id) value="{{ $topic->id }}">{{ $topic->name }}
                    </option>
                @endforeach
            </select>
            <label for="topic_id">Topic (Optional)</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="border rounded p-2 mb-3">
            @foreach ($classroom->students as $student)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="students[]" value="{{ $student->id }}"
                        id="{{ $student->id }}" @checked(!isset($assigned) || in_array($student->id, $assigned))>
                    <label class="form-check-label" for="{{ $student->id }}">
                        {{ $student->name }}
                    </label>
                </div>
            @endforeach
        </div>
        <div class="form-floating mb-3">
            <input type="date" @class(['form-control', 'is-invalid' => $errors->has('published_at')]) id="published_at" name="published_at"
                value="{{ old('published_at', $classwork->published_date) }}">
            <label for="published_at">Publish Time</label>
            <x-error field-name="published_at" />
        </div>
        @if ($type == 'assignment')
            <div class="form-floating mb-3">
                <input type="number" min="0" @class(['form-control', 'is-invalid' => $errors->has('grade')]) id="grade" name="grade"
                    placeholder="Grade" value="{{ old('grade', $classwork->options['grade'] ?? '') }}">
                <label for="grade">Grade</label>
                <x-error field-name="grade" />
            </div>
            <div class="form-floating mb-3">
                <input type="date" @class(['form-control', 'is-invalid' => $errors->has('due')]) id="due" name="due"
                    value="{{ old('due', $classwork->options['due'] ?? '') }}">
                <label for="due">Due</label>
                <x-error field-name="due" />
            </div>
        @endif
    </div>
</div>
