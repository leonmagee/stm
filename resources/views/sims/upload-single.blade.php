@extends('layouts.layout')

@section('title')
Upload Sims for {{ $user->company . ' - ' . $user->name }}
@endsection

@section('content')

<div class="form-wrapper">

  <div class="form-wrapper-inner half">

    <h3>Individual Sims Paste</h3>

    <form action="/upload-single-paste" method="POST" enctype="multipart/form-data">

      <div class="form-wrap">

        {{ csrf_field() }}

        <input type="hidden" name="user_id" value={{ $user->id }} />

        <div class="field">
          <label class="label">Carrier</label>
          <div class="select">
            <select name="carrier_id">
              @foreach($carriers as $carrier)
              <option value="{{ $carrier->id }}">{{ $carrier->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="field">
          <textarea class="textarea" name="sims_paste"></textarea>
        </div>

        <div class="field submit">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Upload</button>
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
