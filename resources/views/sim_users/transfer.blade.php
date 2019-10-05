@extends('layouts.layout')

@section('title')
Transfer Sims
@endsection

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner half">

    <h3>Enter Sims to Transfer</h3>

    <form action="/transfer_sims" id="transfer_sims_form" method="POST" enctype="multipart/form-data">

      <div class="form-wrap">

        {{ csrf_field() }}

        <div class="field">
          <textarea class="textarea" name="sims_paste"></textarea>
        </div>

        <div class="field">

        </div>

        <div class="field submit">
          <div class="control">
            <a href="#" class="modal-open button is-primary">Transfer Sims</a>
            {{-- <button class="button is-hidden" type="submit">Transfer Sims</button> --}}
          </div>
        </div>

      </div>

      @section('modal')

      <h3 class="title">Are You Sure?</h3>

      <button id="modal_transfer_sims" class="button is-danger call-loader" type="submit">Transfer Sims</button>

      <a href="#" class="modal-close-button button is-primary">Cancel</a>

      @endsection

      <div class="field">

        @include('layouts.errors')

      </div>

    </form>

  </div>

</div>

@endsection
