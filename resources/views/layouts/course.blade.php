<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#12263f">
    <title>@yield('title', 'Algoritma dan Dasar Pemrograman')</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 28 28'%3E%3Crect width='28' height='28' rx='7' fill='%2312263f'/%3E%3Crect x='8' y='6' width='12' height='5' rx='2' fill='white'/%3E%3Cpath d='M14 11v4' stroke='white' stroke-width='1.6'/%3E%3Cpath d='M14 15l5 4.5-5 4.5-5-4.5z' fill='none' stroke='%23f5b301' stroke-width='1.8' stroke-linejoin='round'/%3E%3C/svg%3E">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --ink:#12263f;--ink-2:#3a4b61;--muted:#5d6a7c;
            --paper:#f5f7fa;--surface:#fff;--line:#dde3ea;--line-strong:#bfc9d6;
            --blue:#1d4ed8;--blue-dark:#1639a8;--blue-tint:#e8eefc;
            --amber:#f5b301;
            --open:#0c6e4c;--open-bg:#e0f3ea;--hide:#55627a;--hide-bg:#e9edf2;
            --danger:#b42318;--danger-bg:#fdecea;--danger-line:#f5c2bd;
            --ok-bg:#e8f6ee;--ok-line:#b4e3c6;--ok:#14532d;
            --font:"Plus Jakarta Sans",system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;
            --mono:"JetBrains Mono",ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;
            color-scheme:light;
        }
        *,*::before,*::after{box-sizing:border-box}
        html{-webkit-text-size-adjust:100%}
        body{margin:0;position:relative;min-height:100vh;display:flex;flex-direction:column;background:var(--paper);color:var(--ink);font:16px/1.6 var(--font);-webkit-font-smoothing:antialiased}
        /* kertas berpetak tipis di bagian atas halaman */
        body::before{content:"";position:absolute;inset:0 0 auto 0;height:380px;z-index:-1;pointer-events:none;
            background-image:linear-gradient(rgba(18,38,63,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(18,38,63,.055) 1px,transparent 1px);
            background-size:32px 32px;-webkit-mask-image:linear-gradient(#000 30%,transparent);mask-image:linear-gradient(#000 30%,transparent)}
        a{color:var(--blue);text-decoration:none}
        a:hover{text-decoration:underline}
        :focus-visible{outline:3px solid #7ea0f5;outline-offset:2px;border-radius:6px}
        .visually-hidden{position:absolute!important;width:1px;height:1px;margin:-1px;padding:0;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap;border:0}

        /* header */
        .site-header{position:sticky;top:0;z-index:20;background:rgba(255,255,255,.94);backdrop-filter:blur(8px);border-bottom:1px solid var(--line)}
        .bar{max-width:1040px;margin:auto;padding:12px 24px;display:flex;align-items:center;justify-content:space-between;gap:16px}
        .brand{display:flex;align-items:center;gap:10px;min-width:0;color:var(--ink);font-weight:800;letter-spacing:-.01em;line-height:1.2}
        .brand:hover{text-decoration:none}
        .brand svg{flex:none}
        .brand span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        .b-short{display:none}
        .nav{display:flex;align-items:center;gap:4px;flex:none}
        .nav a,.nav button{font:inherit;font-size:.92rem;font-weight:600;color:var(--ink-2);background:none;border:0;padding:8px 12px;border-radius:8px;cursor:pointer}
        .nav a:hover,.nav button:hover{background:var(--hide-bg);color:var(--ink);text-decoration:none}
        .nav form{margin:0}

        /* halaman */
        .wrap{width:100%;max-width:1040px;margin:0 auto;padding:8px 24px 48px;flex:1}
        .hero{padding:44px 0 28px}
        .hero.compact{padding:28px 0 24px}
        h1{font-size:clamp(2rem,5vw,3.1rem);font-weight:800;line-height:1.08;letter-spacing:-.028em;margin:0 0 14px;color:var(--ink);text-wrap:balance}
        .hero.compact h1{font-size:clamp(1.6rem,3.6vw,2.3rem);letter-spacing:-.02em;margin-bottom:10px}
        h2{margin:0;font-size:1.15rem;font-weight:700;letter-spacing:-.01em;line-height:1.3}
        .lead{margin:0;max-width:56ch;color:var(--ink-2);font-size:1.06rem}
        .muted{color:var(--muted)}
        .small{font-size:.875rem}
        .desc{white-space:pre-line;max-width:68ch}

        .crumbs{display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-size:.9rem;color:var(--muted);margin-bottom:22px}
        .crumbs a{font-weight:600}
        .crumbs [aria-current]{color:var(--ink-2)}

        /* kartu & panel */
        .panel{background:var(--surface);border:1px solid var(--line);border-radius:14px;overflow:hidden}
        .panel + .panel{margin-top:20px}
        .panel-head{display:flex;align-items:baseline;justify-content:space-between;gap:12px;padding:18px 22px;border-bottom:1px solid var(--line)}
        .panel-body{padding:22px}
        .empty{padding:36px 22px;text-align:center}
        .empty h2{margin-bottom:6px}
        .empty p{margin:0 auto 18px;max-width:46ch;color:var(--muted)}
        .empty p:last-child{margin-bottom:0}

        /* alur pertemuan (halaman publik) */
        .flow{list-style:none;margin:0;padding:0}
        .flow li{position:relative;display:grid;grid-template-columns:56px minmax(0,1fr);gap:20px;padding-bottom:22px}
        .flow li:not(:last-child)::before{content:"";position:absolute;left:27px;top:56px;bottom:0;width:2px;background:var(--line-strong)}
        .flow li:not(:last-child)::after{content:"";position:absolute;left:22px;bottom:0;border:6px solid transparent;border-top-color:var(--line-strong);border-bottom:0}
        .node{display:grid;place-items:center;width:56px;height:56px;border-radius:14px;background:var(--ink);color:#fff;font-size:1.3rem;font-weight:800;letter-spacing:-.02em;font-variant-numeric:tabular-nums;position:relative;z-index:1}
        .node.sm{width:40px;height:40px;border-radius:11px;font-size:1rem}
        .node.hidden-state{background:var(--hide-bg);color:var(--hide);box-shadow:inset 0 0 0 1.5px var(--line-strong)}
        .step{position:relative;display:flex;flex-direction:column;gap:12px;background:var(--surface);border:1px solid var(--line);border-radius:14px;padding:20px 22px;transition:border-color .15s,box-shadow .15s}
        .step:hover{border-color:var(--blue);box-shadow:0 6px 20px rgba(18,38,63,.07)}
        .step:focus-within{border-color:var(--blue)}
        .step p{margin:0;color:var(--ink-2)}
        .step-foot{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-top:4px}
        .step .btn::after{content:"";position:absolute;inset:0;border-radius:14px}
        .count{display:inline-flex;align-items:center;gap:7px;color:var(--muted);font-size:.9rem;font-weight:500}

        /* tombol */
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:42px;padding:9px 16px;border:1px solid transparent;border-radius:10px;background:var(--blue);color:#fff;font:inherit;font-size:.95rem;font-weight:650;line-height:1.2;cursor:pointer;text-decoration:none;transition:background .15s,border-color .15s}
        .btn:hover{background:var(--blue-dark);text-decoration:none}
        .btn.secondary{background:var(--surface);color:var(--ink);border-color:var(--line-strong)}
        .btn.secondary:hover{background:var(--paper);border-color:var(--ink-2)}
        .btn.danger{background:var(--danger)}
        .btn.danger:hover{background:#8f1c12}
        .btn.quiet-danger{background:none;color:var(--danger);padding-inline:12px}
        .btn.quiet-danger:hover{background:var(--danger-bg)}
        .btn.sm{min-height:36px;padding:6px 12px;font-size:.88rem;border-radius:9px}
        .btn svg{flex:none}
        .actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
        .actions form{margin:0}

        /* daftar file */
        .files{list-style:none;margin:0;padding:0}
        .files li{display:flex;align-items:center;gap:14px;padding:14px 22px}
        .files li + li{border-top:1px solid var(--line)}
        .files .meta{flex:1;min-width:0}
        .files .name{display:block;font-weight:650;word-break:break-word;line-height:1.35}
        .files form{margin:0}
        .ext{flex:none;display:grid;place-items:center;width:52px;height:40px;border-radius:9px;font:500 .72rem/1 var(--mono);letter-spacing:.02em;text-transform:lowercase;background:var(--hide-bg);color:var(--hide)}
        .ext[data-kind=pdf]{background:#fde8e6;color:#a4261b}
        .ext[data-kind=slide]{background:#fff0dc;color:#9a4d00}
        .ext[data-kind=doc]{background:var(--blue-tint);color:#1c3f9e}
        .ext[data-kind=code]{background:#e1f3ea;color:#0c6e4c}
        .ext[data-kind=zip]{background:#ece9f8;color:#4b3d96}

        /* status */
        .pill{display:inline-flex;align-items:center;gap:7px;padding:3px 11px 3px 9px;border-radius:999px;font-size:.8rem;font-weight:700;background:var(--hide-bg);color:var(--hide)}
        .pill::before{content:"";width:7px;height:7px;border-radius:50%;background:currentColor}
        .pill[data-state=open]{background:var(--open-bg);color:var(--open)}

        /* dashboard */
        .rows{list-style:none;margin:0;padding:0}
        .row{display:grid;grid-template-columns:40px minmax(0,1fr) auto auto;align-items:center;gap:8px 16px;padding:16px 22px}
        .row + .row{border-top:1px solid var(--line)}
        .row h2{font-size:1.02rem}
        .row .muted{font-size:.88rem}

        /* alert */
        .flash,.errors{display:flex;gap:10px;align-items:flex-start;padding:12px 16px;border-radius:12px;margin:20px 0 0;font-size:.95rem}
        .flash{background:var(--ok-bg);border:1px solid var(--ok-line);color:var(--ok)}
        .errors{background:var(--danger-bg);border:1px solid var(--danger-line);color:#8f1c12}
        .errors ul{margin:4px 0 0;padding-left:18px}
        .flash svg,.errors svg{flex:none;margin-top:2px}

        /* formulir */
        .field{margin:0 0 20px}
        .field:last-child{margin-bottom:0}
        label.lbl{display:block;font-weight:650;font-size:.95rem;margin-bottom:6px}
        .hint{margin:6px 0 0;font-size:.86rem;color:var(--muted)}
        input[type=text],input[type=email],input[type=password],input[type=number],input:not([type]),textarea{display:block;width:100%;padding:11px 13px;border:1px solid var(--line-strong);border-radius:10px;background:#fff;color:var(--ink);font:inherit;transition:border-color .15s,box-shadow .15s}
        textarea{resize:vertical;min-height:120px;line-height:1.55}
        input:hover,textarea:hover{border-color:var(--ink-2)}
        input:focus,textarea:focus{outline:0;border-color:var(--blue);box-shadow:0 0 0 4px rgba(29,78,216,.16)}
        .two{display:grid;grid-template-columns:1fr 1fr;gap:0 20px}
        .check{display:flex;align-items:center;gap:10px;font-weight:500;cursor:pointer}
        .check input{width:18px;height:18px;margin:0;accent-color:var(--blue)}
        .switch{display:flex;align-items:flex-start;gap:14px;cursor:pointer;position:relative}
        .switch input{position:absolute;opacity:0;width:44px;height:26px;margin:0;cursor:pointer}
        .switch .track{flex:none;width:44px;height:26px;border-radius:999px;background:var(--line-strong);position:relative;transition:background .15s}
        .switch .track::after{content:"";position:absolute;top:3px;left:3px;width:20px;height:20px;border-radius:50%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.25);transition:transform .15s}
        .switch input:checked + .track{background:var(--open)}
        .switch input:checked + .track::after{transform:translateX(18px)}
        .switch input:focus-visible + .track{outline:3px solid #7ea0f5;outline-offset:2px}
        .switch strong{display:block;line-height:1.3}
        .switch small{display:block;color:var(--muted);font-size:.86rem;margin-top:2px}
        .form-actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:26px;padding-top:20px;border-top:1px solid var(--line)}

        .drop{position:relative;display:flex;flex-direction:column;align-items:center;gap:4px;text-align:center;padding:28px 20px;border:2px dashed var(--line-strong);border-radius:12px;background:var(--paper);color:var(--ink-2);transition:border-color .15s,background .15s}
        .drop:hover,.drop:focus-within{border-color:var(--blue);background:var(--blue-tint)}
        .drop input{position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer;margin:0;padding:0}
        .drop svg{color:var(--blue);margin-bottom:4px}
        .drop strong{color:var(--ink)}
        .picked{list-style:none;margin:12px 0 0;padding:0;font-size:.9rem}
        .picked li{display:flex;justify-content:space-between;gap:12px;padding:6px 0;border-bottom:1px dashed var(--line)}
        .picked li.over,.picked-note{color:var(--danger);font-weight:600}
        .picked-note{margin:8px 0 0;font-size:.88rem}
        .section-title{font-size:1rem;font-weight:700;margin:28px 0 0;padding:0 0 12px}

        /* login */
        .auth{max-width:440px;margin:56px auto 0}
        .auth h1{font-size:1.9rem;margin-bottom:8px}
        .auth .lead{font-size:1rem;margin-bottom:24px}
        .auth .btn{width:100%}

        footer{padding:28px 24px;text-align:center;color:var(--muted);font-size:.88rem}

        @media (max-width:720px){
            .row{grid-template-columns:40px minmax(0,1fr) auto}
            .row .actions{grid-column:1 / -1;padding-left:56px}
        }
        @media (max-width:600px){
            .bar{padding:10px 16px}
            .wrap{padding:4px 16px 40px}
            .hero{padding:32px 0 22px}
            .flow li{grid-template-columns:44px minmax(0,1fr);gap:14px}
            .flow li:not(:last-child)::before{left:21px;top:44px}
            .flow li:not(:last-child)::after{left:16px}
            .node{width:44px;height:44px;border-radius:12px;font-size:1.1rem}
            .step{padding:16px}
            .panel-head,.empty{padding-inline:16px}
            .panel-body{padding:18px 16px}
            .files li{padding:14px 16px;flex-wrap:wrap}
            .files .meta{flex-basis:calc(100% - 70px)}
            .files li > .btn,.files li > form{margin-left:66px}
            .row{padding:14px 16px}
            .two{grid-template-columns:1fr}
            .auth{margin-top:28px}
            .b-full{display:none}.b-short{display:inline}
        }
        @media (prefers-reduced-motion:reduce){*,*::before,*::after{transition:none!important}}
    </style>
</head>
<body>
<header class="site-header">
    <div class="bar">
        <a class="brand" href="{{ route('home') }}">
            <svg width="28" height="28" viewBox="0 0 28 28" aria-hidden="true"><rect width="28" height="28" rx="7" fill="#12263f"/><rect x="8" y="6" width="12" height="5" rx="2" fill="#fff"/><path d="M14 11v4" stroke="#fff" stroke-width="1.6"/><path d="M14 15l5 4.5-5 4.5-5-4.5z" fill="none" stroke="#f5b301" stroke-width="1.8" stroke-linejoin="round"/></svg>
            <span class="b-full">Algoritma &amp; Dasar Pemrograman</span><span class="b-short">Algoritma</span>
        </a>
        <nav class="nav" aria-label="Menu utama">
            @auth
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit">Keluar</button></form>
            @else
                @unless(request()->routeIs('admin.login'))
                    <a href="{{ route('admin.login') }}">Login dosen</a>
                @endunless
            @endauth
        </nav>
    </div>
</header>

<main class="wrap">
    @if(session('success'))
        <div class="flash" role="status">
            <svg width="18" height="18" viewBox="0 0 20 20" fill="none" aria-hidden="true"><circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M6 10.4l2.8 2.8L14 7.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if($errors->any())
        <div class="errors" role="alert">
            <svg width="18" height="18" viewBox="0 0 20 20" fill="none" aria-hidden="true"><circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M10 5.8v5M10 13.6v.2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <div><strong>Periksa kembali input:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        </div>
    @endif
    @yield('content')
</main>

<footer>Materi perkuliahan Algoritma dan Dasar Pemrograman</footer>
@stack('scripts')
</body>
</html>
