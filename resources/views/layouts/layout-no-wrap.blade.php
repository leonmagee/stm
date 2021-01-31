<!doctype html>

<html lang="en">

@include('layouts.head')


<body class='stm-body {{ $view_name }}'>

  <div class="stm-absolute-wrap" id="loader-wrap">
    <div class="loader"></div>
  </div>

  @include('layouts.header')

  @include('layouts.nav-mobile')

  <div class="main-wrap">

    @include('layouts.sidebar')

    <div class="middle-content-banner-wrap">

      @include('layouts.banner')
      @include('layouts.banner-non-coupon')

      <div class="middle-content-wrap-no-padding">

        <div id="content">

          @yield('content')

        </div>

      </div>

    </div>

  </div>

  @hassection('modal')
  <div class="modal" id="layout-modal">

    <div class="modal-background"></div>

    <div class="modal-content">

      <div class="modal-box">

        @yield('modal')

      </div>

    </div>

    <button class="modal-close is-large" aria-label="close"></button>

  </div>
  @endif

  @hassection('modal-2')
  <div class="modal" id="layout-modal-2">

    <div class="modal-background"></div>

    <div class="modal-content">

      <div class="modal-box">

        @yield('modal-2')

      </div>

    </div>

    <button class="modal-close-2 is-large" aria-label="close"></button>

  </div>
  @endif

  {{-- <div class="modal" id="layout-modal">

    <div class="modal-background"></div>

    <div class="modal-content">

      <div class="modal-box">

        @yield('modal')

      </div>

    </div>

    <button class="modal-close is-large" aria-label="close"></button>

  </div> --}}

  @include('layouts.footer')

  @include('layouts.scripts')

  @yield('page-script')

</body>

</html>
