<div class="compare__item compare__item--img"><img src="{{ $item->get_cloudinary_thumbnail(200, 200, 'png') }}" /></div>
<div class="compare__item compare__item--name"><a href="/products/{{ $item->id }}">{{ $item->name }}</a></div>
<div class="compare__item">${{ number_format($item->cost, 2) }}</div>
<div class="compare__item compare__item--discount">{{ $item->discount }}%</div>
<div class="compare__item">${{ $item->discount_cost() }}</div>
<div class="compare__item compare__item--rating">
  <div class="rate_yo_wish_list" class="rate_yo_no_hover" rating="{{ (floor($item->get_rating() * 2) / 2) }}"></div>
</div>
<div class="compare__item compare__item--action">
  @if($item->in_stock())
  <a class="compare__item--button compare__item--add-to-cart" href="/add-to-cart-sav-fav/{{ $item->id }}">Add to Cart <i
      class="fas fa-cart-plus"></i></a>
  @else
  <span class="compare__item--button compare__item--sold-out">Out of Stock</span>
  @endif
</div>
