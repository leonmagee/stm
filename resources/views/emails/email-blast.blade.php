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
<div class="email-ad-wrap-outer">
  @foreach($ads_array as $ad)
  <a href="{{ env('APP_URL') }}/products/{{ $ad->id }}">
    <div class="email-ad-wrap">
      <div class="img-wrap">
        <img src="{{ $ad->get_cloudinary_thumbnail(200, 200) }}" />
      </div>
      <div class="title">{{ $ad->name }}</div>
      <div class="description">{!! $ad->ad_text !!}</div>
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
