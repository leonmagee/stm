@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Create New Invoice</h3>

    <form method="POST" action="/new-invoice">

      <div class="form-wrap">

        @csrf

        <div class="form-wrap-flex">

          <div class="field fourth">
            <label class="label" for="user_id">Agent / Dealer<span class="required">*</span></label>
            <div class="select">
              <select name="user_id" id="user_id">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->company }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="field fourth">
            <label class="label" for="due_date">Due Date<span class="required">*</span></label>
            <div class="control">
              <input class="input" type="text" id="due_date" name="due_date" autocomplete="off"
                value="{{ old('due_date') }}" />
            </div>
          </div>
          <div class="field fourth">
            <label class="label" for="status">Status<span class="required">*</span></label>
            <div class="select">
              <select name="status" id="status">
                <option value="1">New</option>
                <option value="2">Pending</option>
                <option value="3">Paid</option>
                <option value="4">Cancelled</option>
              </select>
            </div>
          </div>
          <div class="field fourth">
            <label class="label" for="discount">Discount</label>
            <div class="control">
              <input class="input" type="number" min="0" id="discount" name="discount" value="{{ old('discount') }}" />
            </div>
          </div>
          <div class="field half">
            <label class="label" for="message">Message</label>
            <div class="control">
              <textarea class="textarea" name="message" id="message">{{ old('message') }}</textarea>
            </div>
          </div>
          <div class="field half">
            <label class="label" for="note">Note</label>
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
