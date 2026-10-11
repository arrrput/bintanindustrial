{{--
    Standalone error / maintenance page. Deliberately does NOT extend layouts.main:
    it must still render when the database, sessions or auth are the thing that failed.
    Only uses url()/asset() helpers, inline CSS and inline SVG icons.

    Sections: code, title, message, icon (svg), actions (buttons), extra (optional)
    Optional: @section('refresh', '60') to auto-reload the page (maintenance)
--}}
@php
    // Logo embedded as a data URI: no extra request, so it also shows in a pre-rendered
    // maintenance page (php artisan down --render) and when asset URLs are misconfigured.
    $logoPath = public_path('assets/img/bie.png');
    $logo = is_file($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    @hasSection('refresh')
        <meta http-equiv="refresh" content="@yield('refresh')">
    @endif
    <title>@yield('title') | Bintan Industrial Estate</title>
    @if ($logo)<link rel="icon" href="{{ $logo }}">@endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #335642;
            --brand-dark: #1f3329;
            --brand-soft: #eef5f0;
            --text: #222222;
            --muted: #6c757d;
        }
        * { box-sizing: border-box; }
        html { height: 100%; }
        body {
            margin: 0;
            font-family: "Roboto", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 15% 20%, rgba(51, 86, 66, 0.10), transparent 40%),
                radial-gradient(circle at 85% 80%, rgba(51, 86, 66, 0.12), transparent 45%),
                #f7f9f8;
            min-height: 100%;
            display: flex;
            padding: 24px 16px;
        }
        .error-card {
            width: 100%;
            margin: auto; /* centred, but scrolls instead of clipping on short screens */
            max-width: 560px;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(31, 51, 41, 0.12);
            padding: 48px 40px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .error-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 6px;
            background: linear-gradient(90deg, var(--brand), #4f8a68, var(--brand));
        }
        .logo { max-height: 56px; margin-bottom: 28px; }
        .icon {
            width: 84px;
            height: 84px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: var(--brand-soft);
            color: var(--brand);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .icon svg { width: 42px; height: 42px; }
        .code {
            display: inline-block;
            font-family: "Montserrat", sans-serif;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--brand);
            background: var(--brand-soft);
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 14px;
        }
        h1 {
            font-family: "Montserrat", sans-serif;
            font-weight: 800;
            font-size: 30px;
            line-height: 1.25;
            margin: 0 0 12px;
        }
        p.message {
            color: var(--muted);
            font-size: 16px;
            line-height: 1.7;
            margin: 0 auto 28px;
            max-width: 440px;
        }
        .actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 15px;
            text-decoration: none;
            border: 2px solid var(--brand);
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s, transform 0.2s;
            font-family: inherit;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background: var(--brand); color: #fff; }
        .btn-primary:hover { background: var(--brand-dark); border-color: var(--brand-dark); }
        .btn-outline { background: transparent; color: var(--brand); }
        .btn-outline:hover { background: var(--brand-soft); }
        .btn svg { width: 16px; height: 16px; }
        .extra { margin-top: 28px; padding-top: 20px; border-top: 1px solid #edf0ee; color: var(--muted); font-size: 14px; }
        .extra a { color: var(--brand); font-weight: 500; }
        .footer { margin-top: 24px; font-size: 12px; color: #adb5bd; }
        @media (max-width: 480px) {
            .error-card { padding: 40px 22px 32px; border-radius: 20px; }
            h1 { font-size: 24px; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <main class="error-card" role="main">
        @if ($logo)<img src="{{ $logo }}" alt="Bintan Industrial Estate" class="logo">@endif

        <div class="icon" aria-hidden="true">@yield('icon')</div>

        <div class="code">@yield('code')</div>
        <h1>@yield('title')</h1>
        <p class="message">@yield('message')</p>

        <div class="actions">@yield('actions')</div>

        @hasSection('extra')
            <div class="extra">@yield('extra')</div>
        @endif

        <div class="footer">&copy; {{ date('Y') }} PT Bintan Inti Industrial Estate</div>
    </main>
</body>
</html>
