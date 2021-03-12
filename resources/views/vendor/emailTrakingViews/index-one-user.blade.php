@extends('layouts.layout')
@section(config('mail-tracker.admin-template.section'))

@include('mixins.user-back', ['user' => $user])

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Email Tracker</h3>

    <div class="email-manager-wrap">

      <div class="table-container">
        <table class="table is-bordered is-fullwidth" id="sent-emails">
          <tr>
            <th>Recipient</th>
            <th>Subject</th>
            <th>Opens</th>
            <th class="hide-mobile">Clicks</th>
            <th class="hide-mobile">Bounced</th>
            <th class="hide-mobile">Sent At</th>
            <th>View Email</th>
            <th class="hide-mobile">Clicks</th>
            @if(Auth()->user()->isAdmin())
            <th class="hide-mobile"></th>
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
            <td class="hide-mobile">{{$email->clicks}}</td>
            <td class="hide-mobile">@if($email->bounced)Yes @else No @endif</td>
            <td class="hide-mobile">{{$email->created_at->format(config('mail-tracker.date-format'))}}</td>
            <td>
              <a href="{{route('mailTracker_ShowEmail',$email->id)}}" target="_blank">
                View
              </a>
            </td>
            <td class="hide-mobile">
              @if($email->clicks > 0)
              <a href="{{route('mailTracker_UrlDetail',$email->id)}}">Url Report</a>
              @else
              No Clicks
              @endif
            </td>
            @if(Auth()->user()->isAdmin())
            <td class="hide-mobile"><i class="fas fa-times-circle modal-delete-open" item_id={{ $email->id }}></i></td>
            @endif
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
