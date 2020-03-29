@extends('layouts.layout')
@section(config('mail-tracker.admin-template.section'))

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Emails History</h3>

    <div class="email-manager-wrap">

      <div class="table-container">
        <table class="table is-bordered is-fullwidth" id="sent-emails">
          <tr>
            <th>Subject</th>
            <th>Sent At</th>
            <th>View Email</th>
          </tr>
          @foreach($emails as $email)
          <tr>
            <td>{{$email->subject}}</td>
            <td>{{$email->created_at->format(config('mail-tracker.date-format'))}}</td>
            <td>
              <a href="{{route('mailTracker_ShowEmail',$email->id)}}" target="_blank">
                View
              </a>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
      <div class="no-emails">
        @if($emails->isEmpty())
        You have no emails currently.
        @endif
      </div>
      <div class="nav-wrap">
        {{-- {!! $emails->render() !!} --}}
      </div>
    </div>
  </div>
  @foreach($emails as $email)
  <div class="modal" id="delete-item-modal-{{ $email->id }}">

    <div class="modal-background"></div>

    <div class="modal-content">

      <div class="modal-box">

        <h3 class="title">Are You Sure?</h3>

        <a href="/delete-email-user/{{ $email->id }}/{{ $user->id }}" class="button is-danger">Delete Email</a>
        <a class="modal-delete-close-button button is-primary" item_id={{ $email->id }}>Cancel</a>
      </div>

    </div>

    <button class="modal-delete-close is-large" aria-label="close" item_id={{ $email->id }}></button>

  </div>
  @endforeach
</div>

@endsection
