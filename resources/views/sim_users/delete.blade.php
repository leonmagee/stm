@extends('layouts.layout')

@section('title')
Delete Sims
@endsection

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner third">

    <h3>Enter Sims to Delete</h3>

    <form action="/delete_sims" method="POST" enctype="multipart/form-data">

     <div class="form-wrap">

      {{ csrf_field() }}

      <div class="field">
        <textarea class="textarea" name="sims_paste"></textarea>
      </div>

      <div class="field submit">
        <div class="control">
         <a href="#" class="modal-open button is-danger">Delete Sims</a>
       </div>
     </div>

   </div>

  <div class="field">
    
    @include('layouts.errors')

  </div>

  @section('modal')

  <h3 class="title">Are You Sure?</h3> 

  <button class="button is-danger call-loader" type="submit">Delete Sims</button>

  <a href="#" class="modal-close-button button is-primary">Cancel</a>

  @endsection

 </form>

</div>

</div>

@endsection

