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
    <?php $related = $item->get_related(); ?>
    <div class="saved-favorites__item--description">
      {!! $item->description !!}
    </div>
    <div class="saved-favorites__item--links">
      <a class="saved-favorites__item--link-remove" href="/{{ $link_path }}/{{ $item->id }}">{{ $link }}</a>
      @if($item->in_stock())
      <span class="sep">|</span>
      <a class="saved-favorites__item--link-add" href="/add-to-cart-sav-fav/{{ $item->id }}">Add to Cart</a>
      @endif
      @if($related)
      <span class="sep">|</span>
      <a class="saved-favorites__item--link-compare modal-delete-open" item_id={{ $item->id }}>Compare with Similar
        Items</a>
      @endif
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
  @if($item->in_stock())
  <div class="saved-favorites__item--discount">
    {{ $item->discount }}% Off
  </div>
  @else
  <div class="saved-favorites__item--discount sold-out">
    Sold Out
  </div>
  @endif
</div>

@if($related)
<div class="compare">
  <div class="compare__row compare__row--header">
    <div class="compare__item"></div>
    <div class="compare__item">Name</div>
    <div class="compare__item">Orig Price</div>
    <div class="compare__item">Discount</div>
    <div class="compare__item">Cost</div>
    <div class="compare__item">Rating</div>
    <div class="compare__item"></div>
  </div>

  <div class="compare__row compare__row--current">
    <div class="compare__item compare__item--img"><img src="{{ $item->get_cloudinary_thumbnail(200, 200) }}" /></div>
    <div class="compare__item">{{ $item->name }}</div>
    <div class="compare__item">{{ $item->cost }}</div>
    <div class="compare__item">{{ $item->discount }}%</div>
    <div class="compare__item">{{ $item->cost }}</div>
    <div class="compare__item">5 stars</div>
    <div class="compare__item"><a>Add to Cart</a></div>
  </div>
  @foreach($related as $prod)
  <div class="compare__row compare__row--top">
    <div class="compare__item compare__item--img"><img src="{{ $prod->get_cloudinary_thumbnail(200, 200) }}" /></div>
    <div class="compare__item">{{ $prod->name }}</div>
    <div class="compare__item">{{ $prod->cost }}</div>
    <div class="compare__item">{{ $prod->discount }}%</div>
    <div class="compare__item">{{ $prod->cost }}</div>
    <div class="compare__item">5 stars</div>
    <div class="compare__item"><a>Add to Cart</a></div>
  </div>
  @endforeach
  @else
  <div>No related</div>
  @endif

</div>

<div class="modal" id="delete-item-modal-{{ $item->id }}">

  <div class="modal-background"></div>

  <div class="modal-content">

    <div class="modal-box">

      <h3 class="title">Compare Products</h3>

      @if($related)
      @foreach($related as $prod)
      <div>
        <h4>{{ $prod->name }}</h4>
      </div>
      @endforeach
      @else
      <div>No related</div>
      @endif

      <a class="modal-delete-close-button button is-primary" item_id={{ $item->id }}>Cancel</a>
    </div>

  </div>

  <button class="modal-delete-close is-large" aria-label="close" item_id={{ $item->id }}></button>

</div>
