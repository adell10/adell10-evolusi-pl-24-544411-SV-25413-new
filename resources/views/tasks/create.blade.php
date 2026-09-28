@extends('layouts.app')

@section('title', 'Tambah Tugas')

@section('content')
    <h1>Tambah tugas</h1>

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <div class="field">
            <label for="title">Judul tugas</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
                   placeholder="Contoh: Laporan KEPL" required autofocus>
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn">Simpan tugas</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection