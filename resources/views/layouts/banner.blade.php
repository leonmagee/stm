@if(\Auth::user())
@if($promotion)
<div class="promo-banner">
  <div class="text">Limited time only - {{ $promotion->percent }}% off - use coupon code
    <span>{{ $promotion->code }}</span> - sale end in</div>
  <div class="time" id="countdownTimer" secondsleft="{{ $promotion->seconds_left }}"></div>
</div>
@endif
@endif
