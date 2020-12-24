@if(\Auth::user()->isAdmin())
@if($promotion_non_coupon)
<div class="promo-banner non-coupon">
  <div class="text">{{ $promotion_non_coupon->text }}</div>
</div>
@endif
@endif
