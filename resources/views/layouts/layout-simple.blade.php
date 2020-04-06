<!doctype html>

<html lang="en">

@include('layouts.head')

<body class='stm-body {{ $view_name }}'>

  <div class="stm-absolute-wrap" id="loader-wrap">
    <div class="loader"></div>
  </div>

  @include('layouts.header')

  <div class="main-wrap">

    <div class="middle-content-wrap">

      <h1 class="title">
        @yield('title')
      </h1>

      <div id="content">
        @include('layouts.alert')
        @yield('content')
      </div>

    </div>

  </div>

  @yield('bottom-content')

  @include('layouts.footer')

</body>

</html>

@include('layouts.scripts')

</body>

</html>
