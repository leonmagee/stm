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
      {{-- <ul>
        @foreach($item->product_attributes as $attribute)
        <li>{{ $attribute->text }}</li>
      @endforeach
      </ul> --}}
      {!! $item->description_parsed() !!}
      {{-- {!! $item->description !!} --}}
    </div>
    <div class="saved-favorites__item--links">
      <a class="saved-favorites__item--link-remove" href="/{{ $link_path }}/{{ $item->id }}">{{ $link }} <i
          class="fas fa-times-circle"></i></a>
      @if($item->in_stock())
      <span class="sep">|</span>
      <a class="saved-favorites__item--link-add" href="/add-to-cart-sav-fav/{{ $item->id }}">Add to Cart <i
          class="fas fa-cart-plus"></i></a>
      @endif
      @if($related)
      <span class="sep">|</span>
      <a class="saved-favorites__item--link-compare modal-delete-open" item_id={{ $item->id }}>Compare with Similar
        Items <i class="fas fa-eye"></i></a>
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


<div class="modal modal-width-65" id="delete-item-modal-{{ $item->id }}">

  <div class="modal-background"></div>

  <div class="modal-content">

    <div class="modal-box">

      <h3 class="title">Compare Products</h3>

      @if($related)
      <div class="compare">
        <div class="compare__row compare__row--header">
          <div class="compare__item"></div>
          <div class="compare__item compare__item--name">Product Name</div>
          <div class="compare__item">Orig Price</div>
          <div class="compare__item compare__item--discount">Discount</div>
          <div class="compare__item">Cost</div>
          <div class="compare__item compare__item--rating">Rating</div>
          <div class="compare__item"></div>
        </div>
        <div class="compare__row compare__row--current">
          @include('products.fav-saved-item', ['item' => $item])
        </div>
        @foreach($related as $prod)
        <div class=" compare__row compare__row--top">
          @include('products.fav-saved-item', ['item' => $prod])
        </div>
        @endforeach
      </div>
      @endif
      <a class="modal-delete-close-button button is-primary" item_id={{ $item->id }}>Cancel</a>
    </div>

  </div>

  <button class="modal-delete-close is-large" aria-label="close" item_id={{ $item->id }}></button>

</div>
