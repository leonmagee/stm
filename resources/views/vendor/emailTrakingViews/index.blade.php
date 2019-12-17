@extends('layouts.layout')
@section(config('mail-tracker.admin-template.section'))

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Email Tracker</h3>

    <div class="email-manager-wrap">

      <?php
        $email_id_array = [];
        foreach($emails as $email) {
          $email_id_array[] = $email->id;
        }
        $final_id_array = base64_encode(json_encode($email_id_array));
      ?>

      <form action="{{ route('mailTracker_Search') }}" method="post" class="form-inline">
        <div class="email-header-wrap">
          @csrf
          <input class="input item" type="text" name="search" id="search" placeholder="Text to Search"
            value="{{ session('mail-tracker-index-search') }}">
          <button type="submit" class="button call-loader item search-button">
            Search
          </button>
          <a class="button item clear-button" href="{{ route('mailTracker_ClearSearch') }}">
            Clear Search
          </a>
          @if(Auth()->user()->isAdmin())
          <a class="button is-danger delete-emails modal-delete-open" item_id="page">Delete
            Emails</a>
          @endif
        </div>
      </form>
      <div class="table-container">
        <table class="table is-bordered is-fullwidth" id="sent-emails">
          <tr>
            <th>Recipient</th>
            <th>Subject</th>
            <th>Opens</th>
            <th>Clicks</th>
            <th>Bounced</th>
            <th>Sent At</th>
            <th>View Email</th>
            <th>Clicks</th>
            @if(Auth()->user()->isAdmin())
            <th></th>
            @endif
          </tr>
          @foreach($emails as $email)
          <?php
          $row_class = '';
          if($email->bounced) {
            $row_class = "bounced";
          } elseif($email->opens) {
            $row_class= "opened";
          } else {
            $row_class= "pending";
          }
          ?>
          <tr>
            <td class="{{ $row_class }}">
              @if($email->company)
              {{$email->company}}
              @else
              {{$email->recipient}}
              @endif
            </td>
            <td>{{$email->subject}}</td>
            <td>{{$email->opens}}</td>
            <td>{{$email->clicks}}</td>
            <td>@if($email->bounced)Yes @else No @endif</td>
            <td>{{$email->created_at->format(config('mail-tracker.date-format'))}}</td>
            <td>
              <a href="{{route('mailTracker_ShowEmail',$email->id)}}" target="_blank">
                View
              </a>
            </td>
            <td>
              @if($email->clicks > 0)
              <a href="{{route('mailTracker_UrlDetail',$email->id)}}">Url Report</a>
              @else
              No Clicks
              @endif
            </td>
            @if(Auth()->user()->isAdmin())
            <td><i class="fas fa-times-circle modal-delete-open" item_id={{ $email->id }}></i></td>
            @endif
          </tr>
          @endforeach
        </table>
      </div>
      <div class="nav-wrap">
        {!! $emails->render() !!}
      </div>
    </div>
  </div>
  @foreach($emails as $email)
  <div class="modal" id="delete-item-modal-{{ $email->id }}">

    <div class="modal-background"></div>

    <div class="modal-content">

      <div class="modal-box">

        <h3 class="title">Are You Sure?</h3>

        <a href="/delete-email/{{ $email->id }}" class="button is-danger">Delete Email</a>
        <a class="modal-delete-close-button button is-primary" item_id={{ $email->id }}>Cancel</a>
      </div>

    </div>

    <button class="modal-delete-close is-large" aria-label="close" item_id={{ $email->id }}></button>

  </div>
  @endforeach
</div>

<!-- delete all emails on page modal -->
<div class="modal" id="delete-item-modal-page">

  <div class="modal-background"></div>

  <div class="modal-content">

    <div class="modal-box">

      <h3 class="title">Are You Sure?</h3>

      <a href="/delete-emails/{{ $final_id_array }}" class="button is-danger">Delete Emails</a>
      <a class="modal-delete-close-button button is-primary" item_id="page">Cancel</a>
    </div>

  </div>

  <button class="modal-delete-close is-large" aria-label="close" item_id="page"></button>

</div>




@endsection
