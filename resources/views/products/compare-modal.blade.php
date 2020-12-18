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