<div class="modal" id="menu-modal">

  <div class="modal-background"></div>

  <div class="modal-content">

    <div class="modal-box">

      <div class="close-button-wrap">

        <button class="menu-modal-close button is-primary">Close Menu</button>

      </div>

      <ul class="mobile-menu">

        @foreach($menu as $item)

        <li>

          @if($item['link'])

          <a href="{{ $item['link'] }}">{!! $item['name'] !!}</a>

          @else

          <a class="has-menu">{{ $item['name'] }}</a>

          <ul class="sub-menu">

            @foreach( $item['sub'] as $sub)

            <li><a href="{{ $sub['link'] }}">{{ $sub['name'] }}</a></li>

            @endforeach

          </ul>

          @endif

        </li>

        @endforeach

      </ul>

    </div>

  </div>

</div>
