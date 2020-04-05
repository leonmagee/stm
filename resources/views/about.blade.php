@extends('layouts.layout-simple')

@section('content')

<div class="about-page">

  <div class="about-gs-wireless">

    <h1>About us</h1>
    <p>GS Wireless was established in 1998 as a self-funded venture. We continue to grow & expand to this day. After
      more than a decade, we always maintain profitability & strong financial growth while serving clients all over the
      world. We are an cellphone accessories manufacture & distributor, currently serving over 1000 retail stores across
      the nation (and growing). We are also proud to offer you the top quality products at lowest prices possible plus
      FREE shipping. Our products & services are simply the best, guaranteed. We are located in sunny San Diego,
      California, but we do business nationally & globally. So wherever you are, if we can meet your business cellular
      needs, drop us a line and we’ll do everything possible to provide you with the best wireless solutions.</p>
    <h2>Why choose us?</h2>
    <p>With many distributors to choose from, here are a few reasons why hundreds of retailers have chosen GS Wireless.
      We offer incredible value & warranties on all our products. We include free support & extraordinary customer
      service that many competitors consider an “add-on” for additional cost. You might find “the hottest deal”
      elsewhere, but unreliable sources will always come back to bite you. Let’s face it; it’s the support that matters
      most to you. When you need help, you want it immediately from someone you can understand. Our in-house support
      sets us apart with quick, informative answers delivered in an easy to understand manner by our friendly staff.
      More importantly, we offer you peace of mind & 100% satisfaction guaranteed. (BECAUSE YOU DESERVE IT)</p>
    <h2>Experience you can trust & rely on!</h2>
    <p>Sign-up with GS Wireless & we guarantee your satisfaction. Please take some time to test us out. We’re confident
      that once you start working with us, you won’t want to stop. You’re not just buying our products. We’re creating a
      partnership. We want your business to succeed because when you’re successful, we’re successful. We are committed
      to
      working together so that you’ll never want to go anywhere else. We only hire employees who are passionate and
      knowledgeable about the wireless business & that translates into happy customers. You can count on us to be your
      trusted advisors with the expertise you need. Premium support & customer service can only be as good as the
      infrastructure supporting it, which is why we are meticulous in selecting our team members who will deal with you
      directly.</p>
  </div>

  <div class="video-wrap">
    <div class="video-wrap-inner">
      {!! $embed_1->getHtml() !!}
    </div>
    <div class="video-wrap-inner">
      {!! $embed_2->getHtml() !!}
    </div>
    <div class="video-wrap-inner">
      {!! $embed_3->getHtml() !!}
    </div>
  </div>

</div>

@endsection

@section('bottom-content')

<div class="about-img-wrap">
  <img src="{{ URL::asset('img/about-us.jpg') }}" />
</div>

@endsection
