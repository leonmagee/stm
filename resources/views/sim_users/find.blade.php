@extends('layouts.layout')

@section('title')
Find Sims
@endsection

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner third">

    <h3>Enter Sims Numbers to Search</h3>

    <form action="/delete_sims" method="POST" enctype="multipart/form-data">

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

  <div class="field">
    
    @include('layouts.errors')

  </div>

 </form>

</div>

</div>

@endsection

