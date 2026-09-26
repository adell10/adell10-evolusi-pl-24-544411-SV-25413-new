<!DOCTYPE html>
<html>
<head><title>Daftar Tugas</title></head>
<body>
    <h1>Daftar Tugas</h1>
    <a href="{{ route('tasks.create') }}">+ Tambah Tugas</a>
    <ul>
        @foreach($tasks as $task)
            <li>
                {{ $task->title }} — {{ $task->is_done ? 'Selesai' : 'Belum' }}
                <a href="{{ route('tasks.edit', $task) }}">Edit</a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>