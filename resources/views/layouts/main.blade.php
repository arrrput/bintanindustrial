<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  
  <title>@yield('title', 'Bintan Industrial Estate')</title>
  
  <meta name="description" content="bintanindustrial - Your trusted industrial estate partner">
  <meta name="keywords" content="">

  <link href="{{ asset('assets/img/bie.png') }}" rel="icon">
  <link href="{{ asset('assets/img/bie.png') }}" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  @if(Request::is('/') || Request::is('factory/custom') || Request::is('factory/simulation'))
  <link rel="stylesheet" href="{{ asset('assets/css/pages/layouts-main-1.css') }}">
  @endif

  <link rel="stylesheet" href="{{ asset('assets/css/pages/layouts-main-2.css') }}">
  @stack('styles')
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:biie@biie.co.id">biie@biie.co.id</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+65 6389 3535</span></i>
        </div>
        <div class="social-links d-flex align-items-center">
          <a href="https://www.instagram.com/biieofficial?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="https://www.linkedin.com/company/biie/" target="_blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div><div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="logo d-flex align-items-center">
          <img src="{{ asset('assets/img/bie.png') }}" alt="" style="max-height: 50px; transition: 0.3s;">
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ url('/bie') }}" class="{{ Request::is('bie*') ? 'active' : '' }}">BIE</a></li> 
                <li><a href="{{ url('/life') }}" class="{{ Request::is('life*') ? 'active' : '' }}">Life</a></li>
                <li><a href="{{ url('/careers') }}" class="{{ Request::is('careers*') ? 'active' : '' }}">Careers</a></li>
                <li><a href="{{ url('/blogs') }}" class="{{ (Request::is('blogs*') || Request::is('blog*')) ? 'active' : '' }}">Blogs</a></li>
                @auth
                    <li class="cms-divider-custom" style="width: 1px; height: 20px; background: #ddd; margin: 0 8px; display: inline-block; vertical-align: middle;"></li>
                    <li class="dropdown user-dropdown">
                        <a href="#" class="d-flex align-items-center gap-2 user-dropdown-toggle {{ Request::is('cms*') ? 'active' : '' }}">
                            <div class="avatar-sm" style="width: 34px; height: 34px; background: var(--accent-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0;">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="fw-bold text-truncate" style="color: var(--accent-color); max-width: 120px;">{{ auth()->user()->name }}</span>
                            <i class="bi bi-chevron-down toggle-dropdown-custom" style="color: var(--accent-color); font-size: 12px; flex-shrink: 0;"></i>
                        </a>
                        <ul class="user-dropdown-menu shadow-lg border-0" style="border-radius: 12px; padding: 10px; min-width: 200px;">
                            <li class="px-3 py-2 border-bottom mb-2">
                                <div class="fw-bold text-dark">{{ auth()->user()->name }}</div>
                                <div class="small text-muted" style="font-size: 11px;">{{ auth()->user()->email }}</div>
                            </li>
                            <li><a href="{{ route('cms.dashboard') }}" class="dropdown-item-custom rounded-3 py-2 px-3 d-block"><i class="bi bi-speedometer2 me-2"></i> Dashboard CMS</a></li>
                            
                            @role('IT')
                            <li class="dropdown-divider my-2"></li>
                            <li class="px-3 py-1"><span class="text-muted small fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">System</span></li>
                            <li><a href="{{ route('cms.users.index') }}" class="dropdown-item-custom rounded-3 py-2 px-3 d-block"><i class="bi bi-people me-2"></i> Manage User</a></li>
                            <li><a href="{{ route('cms.logs.index') }}" class="dropdown-item-custom rounded-3 py-2 px-3 d-block"><i class="bi bi-clock-history me-2"></i> Log Activity</a></li>
                            @endrole
                            <li class="dropdown-divider my-2"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item-logout rounded-3 w-100 text-start border-0 bg-transparent py-2 px-3 text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="cms-divider-custom" style="width: 1px; height: 20px; background: #ddd; margin: 0 15px; display: inline-block; vertical-align: middle;"></li>

                    <li class="nav-cms-item">
                        <a class="nav-link fw-bold text-success ms-lg-3 {{ Request::is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            <i class="fa-solid fa-user-lock me-1"></i> CMS
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

      </div>

    </div>

  </header>

  <main class="main">
    
    @yield('content')

  </main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4 justify-content-center">

        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ url('/') }}" class="d-flex align-items-center">
            <img src="{{ asset('assets/img/bie.png') }}" alt="Bintan Industrial Estate" style="max-height: 80px;">
          </a>
        </div>

        <div class="col-lg-4 col-md-6 footer-about">
          <div class="footer-contact">
            <p><strong>Address:</strong> Tanjung Lobam Road, Tlk. Lobam, Kepulauan Riau PO Box 020 29154</p>
            <p class="mt-3"><strong>Phone:</strong> <span>(0770) 696833</span></p>
            <p><strong>Email:</strong> <span>biie@biie.co.id</span></p>
          </div>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <p>Follow us on our social media channels for the latest updates and news.</p>
          <div class="social-links d-flex">
            <a href="https://www.instagram.com/biieofficial?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://www.linkedin.com/company/biie/" target="_blank"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename"></strong> <span>All Rights Reserved</span></p>
    </div>

  </footer>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @if(Request::is('/') || Request::is('factory/custom') || Request::is('factory/simulation'))
  <div id="preloader">
    <video muted loop playsinline id="preloader-video" onloadedmetadata="this.parentElement.classList.add('video-ready')">
      <source src="{{ asset('assets/vid/preloader.mp4') }}" type="video/mp4">
    </video>
  </div>
  @endif

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

  <script src="{{ asset('assets/js/main.js') }}"></script>
  <!-- Lenis Smooth Scroll -->
  <script src="https://unpkg.com/lenis@1.1.9/dist/lenis.min.js"></script>
  <script src="{{ asset('assets/js/pages/layouts-main-js-1.js') }}"></script>
@stack('scripts')
<link rel="stylesheet" href="{{ asset('assets/css/pages/layouts-main-3.css') }}">
<script src="{{ asset('assets/js/pages/layouts-main-js-2.js') }}"></script>
</body>
</html>