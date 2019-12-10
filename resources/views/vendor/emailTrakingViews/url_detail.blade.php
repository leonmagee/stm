@extends('layouts.layout')
{{-- @extends(config('mail-tracker.admin-template.name')) --}}
@section(config('mail-tracker.admin-template.section'))

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Email Tracker</h3>

    <div class="email-manager-wrap">
      <div class="click-details-header">
        <h4>
          <a href="{{route('mailTracker_Index',['page'=>session('mail-tracker-index-page')])}}"
            class='btn btn-default'>All Sent Emails</a>
        </h4>
        <h4>
          <a href="{{ route('mailTracker_ShowEmail',$details->first()->email->id) }}" class="btn btn-default"
            target="_blank">
            View Message
          </a>
        </h4>
        <h4>
          <span>Recipient:</span> {{$details->first()->email->recipient}}
        </h4>
        <h4>
          <span>Subject:</span> {{$details->first()->email->subject}}
        </h4>
        <h4>
          <span>Sent At:</span> {{$details->first()->email->created_at->format(config('mail-tracker.date-format'))}}
        </h4>
        <h4>
          Clicked URLs for Email ID {{$details->first()->email->id}}
        </h4>
      </div>

      <div class="table-container">
        <table class="table is-striped is-bordered is-fullwidth">
          <th>Url</th>
          <th>Clicks</th>
          <th>First Click At</th>
          <th>Last Click At</th>
          @foreach($details as $detail)
          <tr>
            <td>{{$detail->url}}</td>
            <td>{{$detail->clicks}}</td>
            <td>{{$detail->created_at->format(config('mail-tracker.date-format'))}}</td>
            <td>{{$detail->updated_at->format(config('mail-tracker.date-format'))}}</td>
          </tr>
          @endforeach
        </table>

      </div>

    </div>

  </div>

</div>

@endsection
