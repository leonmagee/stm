@extends('layouts.layout')

@section('content')
@include('layouts.errors')
<div class="users-flex-wrap">
  <div class="users-left-content">
    <div class="single-user-wrap">

      <div class="item company">{{ $user->company}}</div>

      <div class="item role flex-wrap">
        <i class="fas fa-sitemap"></i>
        <span>{{ $role }}</span>
      </div>

      <div class="item name flex-wrap">
        <i class="fas fa-user"></i>
        <span>{{ $user->name }}</span>
      </div>

      @if($user->address || $user->city || $user->state || $user->zip)
      <div class="item address-wrap flex-wrap">
        <i class="fas fa-map-marker-alt"></i>
        <div class="address-wrap-inner">
          <div class="address">{{ $user->address }}</div>
          <div class="city_state_zip">
            {{ $user->city }}, {{ $user->state }} {{ $user->zip }}
          </div>
        </div>
      </div>
      @endif

      <div class="item email flex-wrap">
        <i class="far fa-envelope"></i>
        <span>{{ $user->email }}</span>
      </div>

      <div class="item phone flex-wrap">
        <i class="fas fa-phone"></i>
        <span>{{ $user->phone }}</span>
      </div>

    </div>

    <div class="button-bar-wrap">
      <div class="button-bar">
        <a href="/edit-user/{{ $user->id }}" class="button is-primary">Edit Info</a>
        <a href="/change-password/{{ $user->id }}" class="button is-primary">Change Password</a>
        <a href="/login-tracker/{{ $user->id }}" class="button is-primary">Login Tracker</a>
        <a href="/email-tracker/{{ $user->id }}" class="button is-primary">Email Tracker</a>
        <a href="#" class="modal-open button is-danger">Delete User</a>
      </div>
    </div>




    @if(!$user->isAdminManagerEmployee())

    <div class="reports-wrap reports-wrap-grid">

      @foreach( $recharge_data_array as $item )

      <div class="report-wrap">
        <h3 class='recharge-title'>2nd Recharge</h3>

        <div class="recharge-details">

          @foreach($item['data'] as $data)

          <div class="recharge-item">
            <div class="item">
              <label>{!! $data['act_name'] !!}</label>
              <div class="count">{{ $data['act_count'] }}</div>
            </div>
            <div class="item">
              <label>{!! $data['rec_name'] !!}</label>
              <div class="count">{{ $data['rec_count'] }}</div>
            </div>
            <div class="item percent {{ $data['class'] }}">
              <span>{{ $data['percent'] }}%</span>
            </div>

          </div>

          @endforeach

        </div>

      </div>

      @endforeach

    </div>

    <div class="reports-wrap">

      @foreach( $third_recharge_data_array as $item )

      <div class="report-wrap">
        <h3 class='recharge-title'>3rd Recharge</h3>

        <div class="recharge-details">

          @foreach($item['data'] as $data)

          <div class="recharge-item">
            <div class="item">
              <label>{!! $data['act_name'] !!}</label>
              <div class="count">{{ $data['act_count'] }}</div>
            </div>
            <div class="item">
              <label>{!! $data['rec_name'] !!}</label>
              <div class="count">{{ $data['rec_count'] }}</div>
            </div>
            <div class="item percent {{ $data['class'] }}">
              <span>{{ $data['percent'] }}%</span>
            </div>

          </div>

          @endforeach

        </div>

      </div>

      @endforeach

    </div>
    @endif

  </div>
  @if(!$user->isAdminManagerEmployee())

  <div class="notes-wrap">
    <form method="POST" action="/add-note/{{$user->id}}">
      @csrf
      <label>Add New Note</label>
      <div class="control">
        <textarea class="textarea" name="note">{{ old('note') }}</textarea>
      </div>
      <button class="button is-primary call-loader" type="submit">Add Note</button>
    </form>
    <div class="notes-list-wrap">
      <label>Notes</label>
      @if($notes->count())
      @foreach($notes as $note)
      <div class="note">
        <div class="note-header">
          <span class="date">{{ $note->created_at->format('m/d/Y g:ia') }}</span>
          <span class="user">{{ $note->author }}</span>
          <span class="icon">
            @if(Auth()->user()->isAdmin())
            <i class="fas fa-times-circle modal-delete-open" item_id={{ $note->id }}></i>
            @endif
          </span>
        </div>
        <div class="note-body">{{ $note->text }}</div>
      </div>
      <div class="modal" id="delete-item-modal-{{ $note->id }}">

        <div class="modal-background"></div>

        <div class="modal-content">

          <div class="modal-box">

            <h3 class="title">Are You Sure?</h3>

            <a href="/delete-note/{{ $note->id }}" class="button is-danger">Delete Note</a>
            <a class="modal-delete-close-button button is-primary" item_id={{ $note->id }}>Cancel</a>
          </div>

        </div>

        <button class="modal-delete-close is-large" aria-label="close" item_id={{ $note->id }}></button>

      </div>
      @endforeach
      @else
      <div class="no-notes">No notes have been saved.</div>
      @endif
    </div>
  </div>
  @endif

</div>

@endsection

@section('modal')

<h3 class="title">Are You Sure?</h3>

<a href="/delete-user/{{ $user->id }}" class="button is-danger">Delete User {{ $user->name }} | {{ $user->company }}</a>
<a href="#" class="modal-close-button button is-primary">Cancel</a>

@endsection
