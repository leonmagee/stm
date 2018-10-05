@extends('layouts.layout')

@section('title')
Delete Sims
@endsection

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner third">

    <h3>Enter Sims to Delete</h3>

    <form action="/delete_sims" id="delete_sims_form" method="POST" enctype="multipart/form-data">

     <div class="form-wrap">

      {{ csrf_field() }}

      <div class="field">
        <textarea class="textarea" name="sims_paste"></textarea>
      </div>

      <div class="field submit">
        <div class="control">
         <a href="#" class="modal-open button is-primary">Delete Sims</a>
        <button class="button is-hidden" type="submit">Delete Sims</button>
       </div>
     </div>

   </div>

  @section('modal')

  <h3 class="title">Are You Sure?</h3> 

  <button id="modal_delete_sims" class="button is-danger call-loader" type="submit">Delete Sims</button>

  <a href="#" class="modal-close-button button is-primary">Cancel</a>

  @endsection

    <div class="field">
    
    @include('layouts.errors')

  </div>

 </form>

</div>

</div>

@endsection

