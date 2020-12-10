<div class="compare__item compare__item--img"><img src="{{ $item->get_cloudinary_thumbnail(200, 200) }}" /></div>
<div class="compare__item compare__item--name"><a href="/products/{{ $item->id }}">{{ $item->name }}</a></div>
<div class="compare__item">${{ number_format($item->cost, 2) }}</div>
<div class="compare__item compare__item--discount">{{ $item->discount }}%</div>
<div class="compare__item">${{ $item->discount_cost() }}</div>
<div class="compare__item compare__item--rating">
  <div class="rate_yo_wish_list" class="rate_yo_no_hover" rating="{{ (floor($item->get_rating() * 2) / 2) }}"></div>
</div>
<div class="compare__item">
  @if($item->in_stock())
  <a class="compare__item--add-to-cart" href="/add-to-cart-sav-fav/{{ $item->id }}">Add to Cart</a>
  @else
  <span class="compare__item--sold-out">Sold Out</span>
  @endif
</div>