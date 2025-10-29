<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{config('app.name')}} - {{__('Dashboard')}}</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="{{asset('dashboard/img/kaiadmin/favicon.ico')}}"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{asset('dashboard/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["/dashboard/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('dashboard/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dashboard/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dashboard/css/kaiadmin.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dashboard/css/plugin/toastr.min.css')}}" />
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/custom.css')}}" />

  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="{{ route('home') }}" class="logo">
              <img
                src="{{asset('dashboard/img/kaiadmin/logo_light.svg')}}"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
         @include('dashboard.layouts.components._sidebar')
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="{{route('dashboard.index')}}" class="logo">
                <img
                  src="{{asset('dashboard/img/kaiadmin/logo_light.svg')}}"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          @include('dashboard.layouts.components._navbar')
          <!-- End Navbar -->
        </div>

        <div class="container">
              @yield('content')
        </div>

          @include('dashboard.layouts.components._footer')
      </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{asset('dashboard/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('dashboard/js/core/popper.min.js')}}"></script>
    <script src="{{asset('dashboard/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{asset('dashboard/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{asset('dashboard/js/kaiadmin.min.js')}}"></script>

    <!-- Toastr JS -->
    <script src="{{asset('dashboard/js/plugin/toastr.min.js')}}"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Custom JS -->
    <script src="{{asset('dashboard/js/custom.js')}}"></script>

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "showDuration": "500",
            "hideDuration": "1000",
            "timeOut": "5000"
        };
        @foreach (session('flash_notification', collect())->toArray() as $message)
            toastr.{{$message['level']}}('{!! str_replace("'", '', $message['message']) !!}');
        @endforeach
        
        // Initialize Select2 for multi-select fields
        $(document).ready(function() {
            $('.select2-multiselect').select2({
                placeholder: 'Select options',
                allowClear: true
            });
        });
    </script>

  </body>
</html>
