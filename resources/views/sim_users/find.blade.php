@extends('layouts.layout')

@section('title')
Find Sims
@endsection

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner half">

    <h3>Enter Sims Numbers to Search</h3>

    <form action="/find_sims" method="POST" enctype="multipart/form-data">

     <div class="form-wrap">

      {{ csrf_field() }}

      <div class="field">
        <textarea class="textarea" name="sims_paste"></textarea>
      </div>

      <div class="field submit">
        <div class="control">
         <button class="button is-link call-loader" type="submit">Find Sims</button>
       </div>
     </div>

   </div>

 </form>

</div>

<div class="form-wrapper-inner half">

  <h3>Enter Phone Numbers to Search</h3>

    <form action="/find_sims_phone" method="POST" enctype="multipart/form-data">

     <div class="form-wrap">

      {{ csrf_field() }}

      <div class="field">
        <textarea class="textarea" name="phones_paste"></textarea>
      </div>

      <div class="field submit">
        <div class="control">
         <button class="button is-link call-loader" type="submit">Find Sims</button>
       </div>
     </div>

   </div>

 </form>

</div>

@include('layouts.errors')

</div>

@endsection

