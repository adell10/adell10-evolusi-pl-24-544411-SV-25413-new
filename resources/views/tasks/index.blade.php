@extends('layouts.app')

@section('title', 'Daftar Tugas')

@section('styles')
    .task-list { list-style: none; margin: 0 0 var(--line); padding: 0; }
    .task-list li { display: flex; align-items: center; gap: 14px; min-height: var(--line); }
    .dot { flex: none; position: relative; width: 20px; height: 20px; border: 2px solid var(--ink); border-radius: 50%; }
    .done .dot { background: var(--ink); }
    .done .dot::after {
        content: ''; position: absolute; left: 5px; top: 1px; width: 5px; height: 10px;
        border: solid #fff; border-width: 0 2px 2px 0; transform: rotate(45deg);
    }
    .title { font-size: 18px; }
    .done .title-text {
        color: var(--muted); text-decoration: line-through; text-decoration-color: var(--ink);
        background: linear-gradient(transparent 55%, var(--highlight) 55%);
        -webkit-box-decoration-break: clone; box-decoration-break: clone;
    }
    .row-actions { margin-left: auto; display: flex; gap: 14px; white-space: nowrap; }
    .row-actions form { margin: 0; }
    .empty { font-family: 'Kalam', cursive; font-size: 20px; color: var(--muted); }
@endsection

@section('content')
    <h1>Daftar tugas</h1>

    @php
        $done = $tasks->where('is_done', true)->count();
    @endphp

    <p class="muted">{{ $done }} dari {{ $tasks->count() }} tugas sudah selesai.</p>

    @if ($tasks->isEmpty())
        <p class="empty">Belum ada tugas yang tercatat.</p>
    @else
        <ul class="task-list">
            @foreach ($tasks as $task)
                <li class="{{ $task->is_done ? 'done' : '' }}">
                    <span class="dot" aria-hidden="true"></span>
                    <span class="title">
                        <span class="title-text">{{ $task->title }}</span>
                        <span class="muted" style="font-size: 14px;">({{ $task->is_done ? 'Selesai' : 'Belum' }})</span>
                    </span>
                    <span class="row-actions">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn-link">Edit</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                              onsubmit="return confirm('Hapus tugas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-link danger">Hapus</button>
                        </form>
                    </span>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('tasks.create') }}" class="btn">Tambah tugas</a>
@endsection