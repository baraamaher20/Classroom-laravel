<div class="form-floating mb-3">
    <input type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) id="name" name="name" placeholder="name"
        value="{{ old('name', $classroom->name) }}">
    <label for="name">Class Name</label>
    <x-error field-name="name" />
</div>

<div class="form-floating mb-3">
    <input type="text" @class(['form-control', 'is-invalid' => $errors->has('section')]) id="section" name="section" placeholder="Section"
        value="{{ old('section', $classroom->section) }}">
    <label for="section">Section</label>
    <x-error field-name="section" />

</div>

<div class="form-floating mb-3">
    <input type="text" @class(['form-control', 'is-invalid' => $errors->has('subject')]) id="subject" name="subject" placeholder="Subject"
        value="{{ old('subject', $classroom->subject) }}">
    <label for="subject">Subject</label>
    <x-error field-name="subject" />

</div>

<div class="form-floating mb-3">
    <input type="text" @class(['form-control', 'is-invalid' => $errors->has('room')]) id="room" name="room" placeholder="Room"
        value="{{ old('room', $classroom->room) }}">
    <label for="room">Room</label>
    <x-error field-name="room" />

</div>

<div class="form-floating mb-3">
    @if ($classroom->cover_image_path)
        <img src="{{ Storage::disk('public')->url($classroom->cover_image_path) }}"
            style="  border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 200px;margin-bottom: 10px">
    @endif
    <input type="file" @class(['form-control', 'is-invalid' => $errors->has('cover_image')]) id="cover_image" name="cover_image" placeholder="Cover Image">
    <label for="cover_image">Cover Image</label>
    <x-error field-name="cover_image" />

</div>
<div class="d-flex col-3">
    <button type="submit" class="mx-1 btn btn-outline-primary">{{ $button_lable }}</button>
    <a href="{{ route('classrooms.index') }}" class="btn btn-outline-primary">Home</a>
</div>
