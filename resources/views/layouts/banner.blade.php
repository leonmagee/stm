@if(\Auth::user())
@if(\Auth::user()->isAdmin())
@if($promotion)
<div class="promo-banner">
  <div class="text">Limited time only - {{ $promotion->percent }}% off - use coupon code
    <span>{{ $promotion->code }}</span></div>
  <div class="time" id="countdownTimer" secondsleft="{{ $promotion->seconds_left }}"></div>
</div>
@endif
@endif
@endif
