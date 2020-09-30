<div class="header-wrap">

  <div class="logo-wrap">
    <a href="/">
      {{-- <img src="{{ URL::asset('img/gs-stm-logo.png') }}" /> --}}
      <img src="{{ URL::asset('img/stm_logo_white.png') }}" />
    </a>
    <a class="menu-toggle menu-modal-open"><i class="fas fa-bars"></i></a>
  </div>

  <div class="header-area">
    <div class="header-buttons-outer-wrap">
      @if (Auth::check())

      @if($logged_in_user->isAdmin())

      <div class="large-menu">
        @include('layouts.search-user')
        <div class="field has-addons">
          <p class="control">
            <a class="button type" href="/settings">
              <span class="icon is-small">
                <i class="fas fa-sitemap"></i>
              </span>
              <span class="text">{{ $site }}</span>
            </a>
          </p>
          <p class="control">
            <a class="button date" href="/settings">
              <span class="icon is-small">
                <i class="fas fa-calendar"></i>
              </span>
              <span class="text">{{ $current_date }}</span>
            </a>
          </p>
          <p class="control">
            <a class="button user" href="/profile">
              <span class="icon is-small">
                <i class="fas fa-user"></i>
              </span>
              <span class="text">{{ Auth::user()->name }}</span>
            </a>
          </p>
          <p class="control">
            <a class="button logout" href="/logout">
              <span class="icon is-small">
                <i class="fas fa-times-circle"></i>
              </span>
              <span class="text">Log Out</span>
            </a>
          </p>
          <p class="control">
            <a class="button mode {{ $mode }}" href="/settings">
              <span class="icon is-small">
                @if($mode == 'online')
                <i class="fas fa-signal"></i>
                @else
                <i class="fas fa-lock"></i>
                @endif
              </span>
              <span class="text">{{ $mode }}</span>
            </a>
          </p>
        </div>
      </div>

      <div class="mobile-menu">
        <div class="field has-addons">
          <p class="control">
            <a class="button date add-radius" href="/settings">
              <span class="icon is-small">
                <i class="fas fa-calendar"></i>
              </span>
              <span class="text">{{ $current_date }}</span>
            </a>
          </p>
        </div>
        <div class="field has-addons">
          <p class="control">
            <a class="button logout" href="/logout">
              <span class="icon is-small">
                <i class="fas fa-times-circle"></i>
              </span>
              <span class="text">Log Out</span>
            </a>
          </p>
          <p class="control">
            <a class="button mode {{ $mode }}" href="/settings">
              <span class="icon is-small">
                @if($mode == 'online')
                <i class="fas fa-signal"></i>
                @else
                <i class="fas fa-lock"></i>
                @endif
              </span>
              <span class="text">{{ $mode }}</span>
            </a>
          </p>
        </div>
        @include('layouts.search-user')
      </div>

      @elseif($logged_in_user->isManager())

      <div class="large-menu">
        @include('layouts.search-user')
        <div class="field has-addons">
          <p class="control">
            <a class="button type" href="/settings">
              <span class="icon is-small">
                <i class="fas fa-sitemap"></i>
              </span>
              <span class="text">{{ $site }}</span>
            </a>
          </p>
          <p class="control">
            <a class="button date not-link">
              <span class="icon is-small">
                <i class="fas fa-calendar"></i>
              </span>
              <span class="text">{{ $current_date }}</span>
            </a>
          </p>
          <p class="control">
            <a href="/profile" class="button user">
              <span class="icon is-small">
                <i class="fas fa-user"></i>
              </span>
              <span class="text">{{ Auth::user()->name }}</span>
            </a>
          </p>
          <p class="control">
            <a class="button logout" href="/logout">
              <span class="icon is-small">
                <i class="fas fa-times-circle"></i>
              </span>
              <span class="text">Log Out</span>
            </a>
          </p>
          <p class="control">
            <a class="button mode not-link {{ $mode }}">
              <span class="icon is-small">
                @if($mode == 'online')
                <i class="fas fa-signal"></i>
                @else
                <i class="fas fa-lock"></i>
                @endif
              </span>
              <span class="text">{{ $mode }}</span>
            </a>
          </p>
        </div>
      </div>

      <div class="mobile-menu">
        <div class="field has-addons">
          <p class="control">
            <a class="button date not-link add-radius">
              <span class="icon is-small">
                <i class="fas fa-calendar"></i>
              </span>
              <span class="text">{{ $current_date }}</span>
            </a>
          </p>
        </div>
        <div class="field has-addons">
          <p class="control">
            <a class="button logout" href="/logout">
              <span class="icon is-small">
                <i class="fas fa-times-circle"></i>
              </span>
              <span class="text">Log Out</span>
            </a>
          </p>
          <p class="control">
            <a class="button mode not-link {{ $mode }}">
              <span class="icon is-small">
                @if($mode == 'online')
                <i class="fas fa-signal"></i>
                @else
                <i class="fas fa-lock"></i>
                @endif
              </span>
              <span class="text">{{ $mode }}</span>
            </a>
          </p>
        </div>

      </div>

      @elseif($logged_in_user->isEmployee())
      <div class="large-menu">
        @include('layouts.search-user')
        <div class="field has-addons">
          <p class="control">
            <a class="button type not-link">
              <span class="icon is-small">
                <i class="fas fa-sitemap"></i>
              </span>
              <span class="text">{{ $site }}</span>
            </a>
          </p>
          <p class="control">
            <a class="button date not-link">
              <span class="icon is-small">
                <i class="fas fa-calendar"></i>
              </span>
              <span class="text">{{ $current_date }}</span>
            </a>
          </p>
          <p class="control">
            <a href="/profile" class="button user">
              <span class="icon is-small">
                <i class="fas fa-user"></i>
              </span>
              <span class="text">{{ Auth::user()->name }}</span>
            </a>
          </p>
          <p class="control">
            <a class="button logout" href="/logout">
              <span class="icon is-small">
                <i class="fas fa-times-circle"></i>
              </span>
              <span class="text">Log Out</span>
            </a>
          </p>
          <p class="control">
            <a class="button mode not-link {{ $mode }}">
              <span class="icon is-small">
                @if($mode == 'online')
                <i class="fas fa-signal"></i>
                @else
                <i class="fas fa-lock"></i>
                @endif
              </span>
              <span class="text">{{ $mode }}</span>
            </a>
          </p>
        </div>
      </div>

      <div class="mobile-menu">
        <div class="field has-addons">
          <p class="control">
            <a class="button date not-link add-radius">
              <span class="icon is-small">
                <i class="fas fa-calendar"></i>
              </span>
              <span class="text">{{ $current_date }}</span>
            </a>
          </p>
        </div>
        <div class="field has-addons">
          <p class="control">
            <a class="button logout" href="/logout">
              <span class="icon is-small">
                <i class="fas fa-times-circle"></i>
              </span>
              <span class="text">Log Out</span>
            </a>
          </p>
          <p class="control">
            <a class="button mode not-link {{ $mode }}">
              <span class="icon is-small">
                @if($mode == 'online')
                <i class="fas fa-signal"></i>
                @else
                <i class="fas fa-lock"></i>
                @endif
              </span>
              <span class="text">{{ $mode }}</span>
            </a>
          </p>
        </div>

      </div>

      @else


      <div class="large-menu">
        @if($logged_in_user->isMasterAgent())
        @include('layouts.search-user')
        @endif
        <div class="field available-credit">
          Available Credit: <span>${{ number_format(Auth::user()->balance, 2) }}</span>
        </div>
        <div class="field has-addons">
          <p class="control">
            <a href="/your-purchases" class="button user">
              <span class="icon is-small">
                <i class="fas fa-shopping-bag"></i>
              </span>
              <span class="text">My Purchases</span>
            </a>
          </p>
          <p class="control">
            <a href="/your-rmas" class="button user">
              <span class="icon is-small">
                <i class="fas fa-box"></i>
              </span>
              <span class="text">My RMAs</span>
            </a>
          </p>
          <p class="control">
            <a href="/profile" class="button user">
              <span class="icon is-small">
                <i class="fas fa-user"></i>
              </span>
              <span class="text">{{ Auth::user()->name }}</span>
            </a>
          </p>
          <p class="control">
            <a href="/contact" class="button user">
              <span class="icon is-small">
                <i class="fas fa-envelope"></i>
              </span>
              <span class="text">Contact Us</span>
            </a>
          </p>
          <p class="control">
            <a class="button logout" href="/logout">
              <span class="icon is-small">
                <i class="fas fa-times-circle"></i>
              </span>
              <span class="text">Log Out</span>
            </a>
          </p>
          <p class="control">
            <a class="button cart" href="/cart">
              <span class="icon is-small">
                <i class="fas fa-shopping-cart"></i>
              </span>
              <span class="text">Cart</span>
            </a>
          </p>
          {{-- <p class="control">
                        <a class="button mode not-link {{ $mode }}">
          <span class="icon is-small">
            @if($mode == 'online')
            <i class="fas fa-signal"></i>
            @else
            <i class="fas fa-lock"></i>
            @endif
          </span>
          <span class="text">{{ $mode }}</span>
          </a>
          </p> --}}
        </div>
      </div>

      <div class="mobile-menu">
        <div class="field has-addons">
          <p class="control">
            <a class="button logout" href="/logout">
              <span class="icon is-small">
                <i class="fas fa-times-circle"></i>
              </span>
              <span class="text">Log Out</span>
            </a>
          </p>
          <p class="control">
            <a class="button mode not-link {{ $mode }}">
              <span class="icon is-small">
                @if($mode == 'online')
                <i class="fas fa-signal"></i>
                @else
                <i class="fas fa-lock"></i>
                @endif
              </span>
              <span class="text">{{ $mode }}</span>
            </a>
          </p>
        </div>

      </div>

      @endif

      @else
      {{-- menu not logged in --}}

      <div class="large-menu-logged-out">
        <li class="item login">
          {{-- <a href="#" class="modal-open button is-danger">Email Invoice</a> --}}
          <a class="item-a modal-open">
            <i class="fas fa-key"></i>
            <span class="text">Login</span>
          </a>
        </li>
        <li class="item about">
          <a class="item-a" href="/about">
            <i class="fas fa-users"></i>
            <span class="text">About</span>
          </a>
        </li>
        <li class="item contact">
          <a class="item-a" href="/contact-us">
            <i class="fas fa-envelope"></i>
            <span class="text">Contact</span>
          </a>
        </li>
        <li class="item links">
          <a class="item-a">
            <i class="fas fa-link"></i>
            <span class="text">Links</span>
          </a>
          <div class="links-sub-menu" id="menu-direct-links">
            <a href="https://h2odirectnow.com" target="_blank">H2O Direct</a>
            <a href="https://pos.gswmax.com" target="_blank">Lyca Direct</a>
            <a href="https://gsposa.instapayportal.com/login" target="_blank">GS Posa</a>
          </div>
        </li>

      </div>

      @endif
    </div>
  </div>

</div>
