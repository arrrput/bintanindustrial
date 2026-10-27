@php
    // Each card is one line: title, subtitle, url, icon (Bootstrap Icons class), color (icon background).
    // Use 'image' => asset('...') instead of icon + color to show a logo image.
    // To add a new card, copy a line, uncomment it and change the values.
    $links = [
        ['title' => 'Instagram', 'subtitle' => '@biieofficial', 'url' => 'https://www.instagram.com/biieofficial', 'icon' => 'bi-instagram', 'color' => '#E1306C'],
        ['title' => 'LinkedIn', 'subtitle' => 'Bintan Industrial Estate', 'url' => 'https://www.linkedin.com/company/biie/', 'icon' => 'bi-linkedin', 'color' => '#0A66C2'],
        // ['title' => 'YouTube', 'subtitle' => 'Bintan Industrial Estate', 'url' => 'https://www.youtube.com/@yourchannel', 'icon' => 'bi-youtube', 'color' => '#FF0000'],
        ['title' => 'Website', 'subtitle' => request()->getHost(), 'url' => url('/'), 'image' => asset('assets/img/bie.png')],
    ];
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Links | Bintan Industrial Estate</title>
  <meta name="description" content="Official links of Bintan Industrial Estate">

  <link href="{{ asset('assets/img/bie.png') }}" rel="icon">
  <link href="{{ asset('assets/img/bie.png') }}" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <style>
    :root {
      --accent: #335642;
      --text: #1f2a24;
      --muted: #6b7570;
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      min-height: 100vh;
      font-family: "Roboto", system-ui, sans-serif;
      color: var(--text);
      background: linear-gradient(160deg, #eef4f0 0%, #ffffff 45%, #e3ece6 100%);
      display: flex;
      justify-content: center;
      padding: 56px 16px 40px;
    }

    .links-wrap {
      width: 100%;
      max-width: 520px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .links-logo {
      width: 104px;
      height: 104px;
      border-radius: 50%;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 24px rgba(51, 86, 66, 0.15);
      margin-bottom: 18px;
    }

    .links-logo img { max-width: 76%; max-height: 76%; }

    .links-wrap h1 {
      font-family: "Montserrat", sans-serif;
      font-size: 22px;
      font-weight: 700;
      margin: 0 0 6px;
      text-align: center;
    }

    .links-tagline {
      color: var(--muted);
      font-size: 15px;
      margin: 0 0 32px;
      text-align: center;
    }

    .links-list {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 14px;
    }

    .link-card {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 12px 18px 12px 12px;
      background: #fff;
      border: 1px solid rgba(51, 86, 66, 0.12);
      border-radius: 14px;
      text-decoration: none;
      color: var(--text);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
      transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    }

    .link-card:hover {
      transform: translateY(-2px);
      border-color: var(--accent);
      box-shadow: 0 10px 22px rgba(51, 86, 66, 0.14);
    }

    .link-card-icon {
      flex-shrink: 0;
      width: 46px;
      height: 46px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 22px;
    }

    .link-card-icon.is-image {
      background: #fff;
      border: 1px solid rgba(51, 86, 66, 0.12);
    }

    .link-card-icon.is-image img { max-width: 80%; max-height: 80%; }

    .link-card-text { flex: 1; min-width: 0; }

    .link-card-title,
    .link-card-subtitle { display: block; }

    .link-card-title {
      font-family: "Montserrat", sans-serif;
      font-weight: 600;
      font-size: 16px;
    }

    .link-card-subtitle {
      color: var(--muted);
      font-size: 13px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .link-card-arrow {
      color: var(--muted);
      font-size: 18px;
      transition: transform 0.2s, color 0.2s;
    }

    .link-card:hover .link-card-arrow {
      color: var(--accent);
      transform: translateX(3px);
    }

    .links-back {
      margin-top: 36px;
      color: var(--accent);
      font-size: 14px;
      font-weight: 500;
      text-decoration: none;
    }

    .links-back:hover { text-decoration: underline; }

    .links-footer {
      margin-top: 18px;
      color: var(--muted);
      font-size: 12px;
    }
  </style>
</head>

<body>
  <div class="links-wrap">
    <div class="links-logo">
      <img src="{{ asset('assets/img/bie.png') }}" alt="Bintan Industrial Estate">
    </div>
    <h1>Bintan Industrial Estate</h1>
    <p class="links-tagline">Follow us for the latest updates and news.</p>

    <div class="links-list">
      @foreach ($links as $link)
        <a href="{{ $link['url'] }}" class="link-card" target="_blank" rel="noopener">
          @if (isset($link['image']))
            <span class="link-card-icon is-image"><img src="{{ $link['image'] }}" alt="{{ $link['title'] }}"></span>
          @else
            <span class="link-card-icon" style="background: {{ $link['color'] }}"><i class="bi {{ $link['icon'] }}"></i></span>
          @endif
          <span class="link-card-text">
            <span class="link-card-title">{{ $link['title'] }}</span>
            <span class="link-card-subtitle">{{ $link['subtitle'] }}</span>
          </span>
          <i class="bi bi-arrow-right link-card-arrow"></i>
        </a>
      @endforeach
    </div>

    {{-- <a href="{{ route('home') }}" class="links-back"><i class="bi bi-arrow-left"></i> Back to website</a> --}}
    <p class="links-footer">© {{ date('Y') }} Bintan Industrial Estate</p>
  </div>
</body>

</html>
