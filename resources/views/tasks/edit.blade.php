@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')
    <h1>Edit tugas</h1>

    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')
        <div class="field">
            <label for="title">Judul tugas</label>
            <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}" required>
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="check-field">
                <input type="checkbox" name="is_done" value="1" {{ old('is_done', $task->is_done) ? 'checked' : '' }}>
                Tandai sudah selesai
            </label>
        </div>

        <div class="actions">
            <button type="submit" class="btn">Simpan perubahan</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection