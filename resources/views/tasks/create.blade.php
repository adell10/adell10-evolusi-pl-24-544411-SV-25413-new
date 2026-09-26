<!DOCTYPE html>
<html>
<head><title>Tambah Tugas</title></head>
<body>
    <h1>Tambah Tugas</h1>
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <input type="text" name="title" placeholder="Judul tugas" required>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>