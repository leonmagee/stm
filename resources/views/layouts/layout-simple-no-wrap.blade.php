<!doctype html>

<html lang="en">

@include('layouts.head')

<body class='stm-body {{ $view_name }}'>

  <div class="stm-absolute-wrap" id="loader-wrap">
    <div class="loader"></div>
  </div>

  @include('layouts.header')

  @include('layouts.nav-mobile-logged-out')

  <div class="main-wrap">

    {{-- @todo create separate alert which is pos absolute with high z-index / this is hidden by slide --}}
    @include('layouts.alert')

    @yield('content')

  </div>

  @include('layouts.footer')

</body>

</html>

@include('layouts.scripts')

@yield('page-script')

</body>

</html>
