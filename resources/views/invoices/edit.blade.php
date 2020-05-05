@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Edit Invoice</h3>

    <form method="POST" action="/update-invoice/{{ $invoice->id }}">

      <div class="form-wrap">

        @csrf

        <div class="form-wrap-flex">

          <div class="field">
            <label class="label" for="user_id">User<span class="required">*</span></label>
            <div class="select">
              <select name="user_id" id="user_id">
                @foreach ($users as $user)
                <option @if($user->id == $invoice->user_id)
                  selected="selected"
                  @endif
                  value="{{ $user->id }}">{{ $user->company }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="field">
            <label class="label" for="due_date">Due Date<span class="required">*</span></label>
            <div class="control">
              <input class="input" type="text" id="due_date" name="due_date" value="{{ $invoice->due_date }}"
                autocomplete="off" />
            </div>
          </div>
          <div class="field">
            <label class="label" for="status">Status<span class="required">*</span></label>
            <div class="select">
              <select name="status" id="status">
                <option value="1" @if( $invoice->status == 1) selected @endif>New</option>
                <option value="2" @if( $invoice->status == 2) selected @endif>Pending</option>
                <option value="3" @if( $invoice->status == 3) selected @endif>Paid</option>
                <option value="4" @if( $invoice->status == 4) selected @endif>Cancelled</option>
              </select>
            </div>
          </div>
          <div class="field half">
            <label class="label" for="message">Invoice Message</label>
            <div class="control">
              <textarea class="textarea" name="message" id="message">{{ $invoice->message }}</textarea>
            </div>
          </div>
          <div class="field half">
            <label class="label" for="note">Our Note</label>
            <div class="control">
              <textarea class="textarea" name="note" id="note">{{ $invoice->note }}</textarea>
            </div>
          </div>
        </div>
        <div class="field flex-margin">
          <div class="control">
            <button class="button is-primary" type="submit">Update</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection
