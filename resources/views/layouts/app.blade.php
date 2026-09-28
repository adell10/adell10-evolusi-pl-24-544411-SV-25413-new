<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Catatan Tugas')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;700&family=Kalam:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Tema sama dengan frontend Vue: halaman buku tulis bergaris */
        :root {
            --desk: #e4e9f1;
            --paper: #fbfcfe;
            --ink: #1f3a93;
            --text: #25304a;
            --muted: #5b6475;
            --rule: #d3def0;
            --margin: #d9444f;
            --highlight: #ffe45c;
            --line: 32px;
            --gutter: 96px;
            font-family: 'Atkinson Hyperlegible', system-ui, sans-serif;
            font-size: 17px;
            line-height: var(--line);
            color: var(--text);
        }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; background: var(--desk); padding: 32px 16px 64px; }

        .tabs { max-width: 760px; margin: 0 auto; padding-left: var(--gutter); display: flex; gap: 6px; }
        .tabs a {
            font-family: 'Kalam', cursive; font-size: 18px; font-weight: 700; line-height: 1;
            padding: 10px 20px 8px; border-radius: 12px 12px 0 0;
            background: #cdd7e8; color: var(--ink); text-decoration: none;
        }
        .tabs a:hover { background: #dbe3f0; }
        .tabs a.active { background: var(--paper); }

        .sheet {
            max-width: 760px; min-height: calc(100vh - 160px); margin: 0 auto;
            padding: var(--line) 40px calc(var(--line) * 3) var(--gutter);
            background-color: var(--paper);
            background-image:
                linear-gradient(to right, transparent calc(var(--gutter) - 26px), var(--margin) calc(var(--gutter) - 26px), var(--margin) calc(var(--gutter) - 24px), transparent calc(var(--gutter) - 24px)),
                repeating-linear-gradient(to bottom, transparent 0, transparent calc(var(--line) - 1px), var(--rule) calc(var(--line) - 1px), var(--rule) var(--line));
            border-radius: 0 4px 4px 4px;
            box-shadow: 0 24px 48px -28px rgba(31, 58, 147, .45);
        }

        h1 {
            font-family: 'Kalam', cursive; font-weight: 700; font-size: 46px;
            line-height: calc(var(--line) * 2); color: var(--ink); margin: 0 0 var(--line);
        }
        p { margin: 0 0 var(--line); max-width: 60ch; }
        a { color: var(--ink); }
        a:focus-visible, button:focus-visible, input:focus-visible {
            outline: 3px solid var(--ink); outline-offset: 3px; border-radius: 4px;
        }
        .muted { color: var(--muted); }

        .btn {
            display: inline-block; font-family: 'Kalam', cursive; font-weight: 700; font-size: 19px; line-height: 1;
            padding: 11px 20px 9px; border: 0; border-radius: 10px; cursor: pointer; text-decoration: none;
            background: var(--ink); color: #fff; box-shadow: 3px 3px 0 var(--highlight);
        }
        .btn:hover { background: #173077; }
                .btn-secondary {
            background: transparent; color: var(--ink);
            border: 2px solid var(--ink); padding: 9px 18px 7px; box-shadow: none;
        }
        .btn-secondary:hover { background: #eef2fa; }
        .btn-link {
            background: none; border: 0; padding: 0; cursor: pointer;
            font: inherit; font-size: 14px; color: var(--ink); text-decoration: underline;
        }
        .btn-link.danger { color: var(--margin); }

        .field { margin-bottom: var(--line); }
        .field label { display: block; font-weight: 700; color: var(--ink); }
        .field input[type="text"] {
            width: 100%; max-width: 480px; font: inherit; font-size: 20px; color: var(--text);
            height: var(--line); padding: 0 2px; border: 0; border-bottom: 2px solid var(--ink);
            background: transparent;
        }
        .field input[type="text"]:focus { outline: none; background: #fffbe0; }
        .check-field { display: inline-flex; align-items: center; gap: 10px; cursor: pointer; }
        .check-field input { width: 20px; height: 20px; accent-color: var(--ink); margin: 0; }
        .error { color: var(--margin); font-weight: 700; font-size: 15px; margin: 0; }

        .actions { display: flex; align-items: center; gap: 20px; }

        @media (max-width: 600px) {
            :root { --gutter: 56px; font-size: 16px; }
            .sheet { padding-right: 20px; }
            h1 { font-size: 34px; line-height: 44px; }
        }
        @yield('styles')
    </style>
</head>
<body>
    <nav class="tabs" aria-label="Navigasi utama">
        <a href="{{ route('tasks.index') }}" class="{{ request()->routeIs('tasks.index') ? 'active' : '' }}">Daftar Tugas</a>
        <a href="{{ route('tasks.create') }}" class="{{ request()->routeIs('tasks.create') ? 'active' : '' }}">Tambah Tugas</a>
    </nav>
    <div class="sheet">
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>