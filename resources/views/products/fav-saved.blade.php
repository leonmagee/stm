<div class="saved-favorites__item">
  <div class="saved-favorites__item--image">
    <a href="/products/{{ $item->id }}">
      <img src="{{ $item->img_url_1 }}" />
    </a>
  </div>
  <div class="saved-favorites__item--details">
    <div class="saved-favorites__item--name">
      <a href="/products/{{ $item->id }}">
        {{ $item->name }}
      </a>
    </div>
    <div class="saved-favorites__item--description">
      {!! $item->description !!}
    </div>
    <div class="saved-favorites__item--links">
      <a class="saved-favorites__item--link-remove" href="/{{ $link_path }}/{{ $item->id }}">{{ $link }}</a>
      <span class="sep">|</span>
      <a class="saved-favorites__item--link-add" href="/add-to-cart-sav-fav/{{ $item->id }}">Add to Cart</a>
      <span class="sep TEMP-HIDE">|</span>
      <a class="saved-favorites__item--link-compare TEMP-HIDE" href="#">Compare with Similar Items</a>
    </div>
  </div>
  <div class="saved-favorites__item--price">
    @if($item->discount)
    <div class="saved-favorites__item--price-orig">
      ${{ number_format($item->cost, 2) }}
    </div>
    <div class="saved-favorites__item--price-final">
      ${{ number_format(App\Helpers::get_discount_price($item->cost, $item->discount), 2) }}
    </div>
    @else
    <div class="saved-favorites__item--price-final">
      ${{ number_format($item->cost, 2) }}
    </div>
    @endif
  </div>
  <div class="saved-favorites__item--discount">
    {{ $item->discount }}% Off
  </div>
  @foreach($item->get_related() as $related)
  <div>
    <h4>{{ $related->name }}</h4>
  </div>
  @endforeach
</div>
