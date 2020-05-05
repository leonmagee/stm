@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Create an Invoice for {{ $user->company }} - {{ $user->name }}</h3>

    <form method="POST" action="/new-invoice">

      <div class="form-wrap">

        @csrf

        <div class="form-wrap-flex">

          <input type="hidden" name="user_id" value="{{ $user->id }}" />
          <div class="field full">
            <label class="label" for="due_date">Due Date<span class="required">*</span></label>
            <div class="control">
              <input class="input" type="text" id="due_date" name="due_date" autocomplete="off"
                value="{{ old('due_date') }}" />
            </div>
          </div>
          <div class="field half">
            <label class="label" for="message">Invoice Message</label>
            <div class="control">
              <textarea class="textarea" name="message" id="message">{{ old('message') }}</textarea>
            </div>
          </div>
          <div class="field half">
            <label class="label" for="note">Our Note</label>
            <div class="control">
              <textarea class="textarea" name="note" id="note">{{ old('note') }}</textarea>
            </div>
          </div>
        </div>
        <div class="field flex-margin">
          <div class="control">
            <button class="button is-primary" type="submit">Save Invoice</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection
