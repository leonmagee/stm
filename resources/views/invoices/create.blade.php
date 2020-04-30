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

          <div class="field">
            <label class="label" for="role_id">Agent / Dealer<span class="required">*</span></label>
            <div class="select">
              <select name="role_id" id="role_id">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->company }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="field">
            <label class="label" for="due_date">Due Date<span class="required">*</span></label>
            <div class="control">
              <input class="input" type="text" id="due_date" name="due_date" autocomplete="off" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="title">Title</label>
            <div class="control">
              <input class="input" type="text" id="title" name="title" placeholder="INVOICE" />
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
