@component('mail::message')

@if($hello)
{{ $hello }}
@else
@if($user->name)
# Hello {{ $user->name }}
@endif
@endif

{!! $message !!}

@if($ads_array)
@if(count($ads_array))
We have some ads
<div class="email-ad-wrap-outer">
  @foreach($ads_array as $ad)
  <a href="{{ env('APP_URL') }}/products/{{ $ad->id }}">
    <div class="email-ad-wrap">
      <img src="{{ $ad->get_cloudinary_thumbnail(250, 250) }}" />
      <div class="title">{{ $ad->name }}</div>
      <div class="description">{!! $ad->description !!}</div>
    </div>
  </a>
  @endforeach
</div>
@endif
@endif

@component('mail::button', ['url' => 'https://stmmax.com'])
Login to Sim Track Manager
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
