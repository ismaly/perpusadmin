<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Sistem Informasi Perpustakaan SMA Negeri 1 Ranau Tengah</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
    <link rel="icon" href="{{ asset ('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
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
          urls: ["{{ asset ('assets/css/fonts.min.css') }}"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>
  

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset ('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset ('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset ('assets/css/kaiadmin.min.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset ('assets/css/demo.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </head>
  <body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('Admin.template.sidebar')
        <!-- End Sidebar -->
    
        <div class="main-panel">
            @include('Admin.template.header')
    
            @yield('content')
    
            @include('Admin.template.footer')
        </div>
    
      </div>
    @include('Admin.template.script')
  </body>
</html>