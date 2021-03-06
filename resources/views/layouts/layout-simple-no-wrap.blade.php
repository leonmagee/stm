<!doctype html>

<html lang="en">

@include('layouts.head')

<body class='stm-body {{ $view_name }}'>

  <div class="stm-absolute-wrap" id="loader-wrap">
    <div class="loader"></div>
  </div>

  @include('layouts.header')

  @include('layouts.nav-mobile-logged-out')

  <div class="layout-simple-wrap">
    @include('layouts.alert')

    <div class="main-wrap">

      @yield('content')

    </div>
  </div>

  @include('layouts.footer')

</body>

</html>

@include('layouts.scripts')

@yield('page-script')

</body>

</html>
