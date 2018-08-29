@extends('layouts.layout')

@section('title')
Delete Sims
@endsection

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Enter Sims to Delete</h3>

    <form action="/delete_sims" method="POST" enctype="multipart/form-data">

     <div class="form-wrap">

      {{ csrf_field() }}

      <div class="field">
        <textarea class="textarea" name="sims_paste"></textarea>
      </div>

      <div class="field submit">
        <div class="control">
         <button class="button is-link call-loader" type="submit">Delete Sims</button>
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

