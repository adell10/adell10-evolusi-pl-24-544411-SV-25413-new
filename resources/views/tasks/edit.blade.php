<!DOCTYPE html>
<html>
<head><title>Edit Tugas</title></head>
<body>
    <h1>Edit Tugas</h1>
    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')
        <input type="text" name="title" value="{{ $task->title }}" required>
        <label><input type="checkbox" name="is_done" value="1" {{ $task->is_done ? 'checked' : '' }}> Selesai</label>
        <button type="submit">Update</button>
    </form>
</body>
</html>